    <script>
        const CACHE_PREFIX  = 'resepin_';
        const CACHE_TTL     = 60 * 60 * 1000; // 1 jam

        let activeAllergies = [];
        let activeDiets     = [];
        let currentOffset   = 0;
        let lastQuery       = '';
        let isRandomMode    = false;

        // ─── LOCAL STORAGE HELPER ────────────────────────────────────
        function cacheGet(key) {
            try {
                const raw = localStorage.getItem(CACHE_PREFIX + key);
                if (!raw) return null;
                const { data, ts } = JSON.parse(raw);
                if (Date.now() - ts > CACHE_TTL) {
                    localStorage.removeItem(CACHE_PREFIX + key);
                    return null;
                }
                return data;
            } catch (e) { return null; }
        }

        function cacheSet(key, data) {
            try {
                localStorage.setItem(CACHE_PREFIX + key, JSON.stringify({ data, ts: Date.now() }));
            } catch (e) { /* LocalStorage full */ }
        }

        // ─── CHIP TOGGLE ─────────────────────────────────────────────
        function toggleChip(button) {
            const value = button.innerText.trim().toLowerCase();

            button.classList.toggle('bg-slate-100');
            button.classList.toggle('text-slate-700');
            button.classList.toggle('bg-amber-500');
            button.classList.toggle('text-white');
            button.classList.toggle('shadow-sm');

            const isAllergyCard = button.parentElement.previousElementSibling?.innerText.includes('Allergies');
            const targetArray   = isAllergyCard ? activeAllergies : activeDiets;

            if (targetArray.includes(value)) {
                targetArray.splice(targetArray.indexOf(value), 1);
            } else {
                targetArray.push(value);
            }

            currentOffset = 0;
            isRandomMode  = false;
        }

        // ─── SKELETON LOADER ─────────────────────────────────────────
        function showSkeletonLoaders() {
            const container = document.getElementById('carouselContainer');
            let html = '';
            for (let i = 0; i < 3; i++) {
                html += `
                    <div class="bg-white/50 border border-slate-100 rounded-2xl p-4 space-y-4 animate-pulse">
                        <div class="bg-slate-200/80 h-36 rounded-xl w-full"></div>
                        <div class="h-4 bg-slate-200/80 rounded w-2/3"></div>
                        <div class="h-3 bg-slate-200/80 rounded w-1/2"></div>
                    </div>`;
            }
            container.innerHTML = html;
        }

        // ─── RENDER CARD ─────────────────────────────────────────────
        function renderCarouselCards(recipes, animateSwipe = false) {
            const container = document.getElementById('carouselContainer');
            let cardsHtml   = '';

            recipes.forEach(recipe => {
                let badges = '';
                if (recipe.veryPopular) badges += `<span class="text-[10px] font-bold text-white px-2.5 py-0.5 rounded-full shadow-sm" style="background-color:#E91B51;">Popular</span>`;
                if (recipe.cheap)       badges += `<span class="text-[10px] font-bold text-white px-2.5 py-0.5 rounded-full shadow-sm" style="background-color:#F0760F;">Cheap</span>`;
                if (recipe.vegetarian)  badges += `<span class="text-[10px] font-bold text-white px-2.5 py-0.5 rounded-full shadow-sm" style="background-color:#158E36;">Vegetarian</span>`;
                if (recipe.glutenFree)  badges += `<span class="text-[10px] font-bold text-white px-2.5 py-0.5 rounded-full shadow-sm" style="background-color:#A24CCA;">Gluten Free</span>`;

                cardsHtml += `
                    <div class="card-item bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-slate-100 flex flex-col group">
                        <div class="relative h-44 overflow-hidden">
                            <img src="${recipe.image || 'https://images.unsplash.com/photo-1495521821757-a1efb6729352?auto=format&fit=crop&q=80&w=500'}"
                                 alt="${recipe.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-3 left-3 flex flex-col gap-1">${badges}</div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h4 class="font-bold text-sm md:text-base text-slate-950 group-hover:text-amber-500 transition-colors line-clamp-2">${recipe.title}</h4>
                                <div class="flex items-center gap-1 text-slate-400 text-xs mt-1.5">
                                    <i class="fa-regular fa-clock"></i> <span>${recipe.readyInMinutes || 30} mins</span>
                                </div>
                            </div>
                            <button onclick="openRecipeDetail(${recipe.id})"
                                class="w-full py-2 rounded-xl bg-slate-900 hover:bg-amber-500 text-white font-semibold text-xs transition-colors cursor-pointer">
                                View Full Recipe
                            </button>
                        </div>
                    </div>`;
            });

            if (animateSwipe) {
                container.style.opacity   = '0';
                container.style.transform = 'translateX(15px)';
                setTimeout(() => {
                    container.innerHTML       = cardsHtml;
                    container.style.opacity   = '1';
                    container.style.transform = 'translateX(0)';
                }, 250);
            } else {
                container.innerHTML = cardsHtml;
            }
        }

        // ─── FETCH RECIPES (Nutri Search) ────────────────────────────
        async function fetchRecipes(isNextPage = false) {
            const searchInput = document.getElementById('searchInput');
            const query       = searchInput ? searchInput.value.trim() : '';

            if (!isNextPage) {
                currentOffset = 0;
                lastQuery     = query;
            }

            const cacheKey = `search_${lastQuery}_${activeDiets.join(',')}_${activeAllergies.join(',')}_${currentOffset}`;
            const cached   = cacheGet(cacheKey);

            if (cached) {
                renderCarouselCards(cached, isNextPage);
                currentOffset += 3;
                updateNavigationUI(true);
                return;
            }

            showSkeletonLoaders();

            try {
                const url      = `<?= base_url('api/recipes/search') ?>?query=${encodeURIComponent(lastQuery)}&diet=${activeDiets.join(',')}&intolerances=${activeAllergies.join(',')}&offset=${currentOffset}`;
                const response = await fetch(url);
                const data     = await response.json();

                if (data.results && data.results.length > 0) {
                    cacheSet(cacheKey, data.results);
                    renderCarouselCards(data.results, isNextPage);
                    currentOffset += 3;
                    updateNavigationUI(true);
                } else {
                    document.getElementById('carouselContainer').innerHTML = `
                        <p class="col-span-3 text-center text-sm text-slate-500 py-12">
                            <i class="fa-solid fa-cookie-bite text-slate-300 text-3xl block mb-2"></i>
                            Waduh, kriteria pencarian terlalu ketat! Coba kurangi kombinasi filter atau gunakan bahan makanan yang lebih umum ya.
                        </p>`;
                    updateNavigationUI(false);
                }
            } catch (error) {
                console.error('Error fetching recipes:', error);
            }
        }

        // ─── FETCH RANDOM ─────────────────────────────────────────────
        async function fetchRandomRecipes() {
            isRandomMode = true;
            showSkeletonLoaders();

            try {
                const response = await fetch(`<?= base_url('api/recipes/random') ?>`);
                const data     = await response.json();

                if (data.recipes) {
                    renderCarouselCards(data.recipes, false);
                    updateNavigationUI(false);
                }
            } catch (error) {
                console.error('Error fetching random recipes:', error);
            }
        }

        // ─── CAROUSEL NAVIGATION ───────────────────────────────────────
        function slideRight() { if (!isRandomMode) fetchRecipes(true); }

        function slideLeft() {
            if (currentOffset > 3 && !isRandomMode) {
                currentOffset -= 6;
                if (currentOffset < 0) currentOffset = 0;
                fetchRecipes(true);
            }
        }

        function updateNavigationUI(hasData) {
            const prevBtn = document.getElementById('prevBtn');
            const canPrev = currentOffset > 3;
            prevBtn.disabled = !canPrev;
            prevBtn.classList.toggle('opacity-50',        !canPrev);
            prevBtn.classList.toggle('cursor-not-allowed', !canPrev);
            prevBtn.classList.toggle('cursor-pointer',      canPrev);
        }

        // ─── MODAL DETAIL RECIPE ───────────────────────────────────────
        async function openRecipeDetail(id) {
            const modal          = document.getElementById('recipeModal');
            const modalContainer = modal.querySelector('div');

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalContainer.classList.remove('scale-95');
            modalContainer.classList.add('scale-100');

            document.getElementById('modalRecipeTitle').innerText = 'Loading...';
            document.getElementById('modalRecipeImage').src       = '';
            document.getElementById('modalNutritionGrid').innerHTML   = '';
            document.getElementById('modalIngredientsList').innerHTML  = '';
            document.getElementById('modalInstructionsList').innerHTML = '';

            const cacheKey = `detail_${id}`;
            const cached   = cacheGet(cacheKey);

            if (cached) {
                injectModal(cached);
                return;
            }

            try {
                const response = await fetch(`<?= base_url('api/recipes/detail') ?>/${id}`);
                const recipe   = await response.json();
                cacheSet(cacheKey, recipe);
                injectModal(recipe);
            } catch (error) {
                console.error('Error loading recipe detail:', error);
            }
        }

        function injectModal(recipe) {
            document.getElementById('modalRecipeTitle').innerText     = recipe.title;
            document.getElementById('modalRecipeImage').src           = recipe.image;
            document.getElementById('modalPrepTime').innerText        = `${recipe.readyInMinutes || 30} minutes`;

            const nutrients = recipe.nutrition?.nutrients || [];
            const find      = name => nutrients.find(n => n.name === name)?.amount || 0;

            document.getElementById('modalNutritionGrid').innerHTML = `
                <div class="bg-rose-50/60 border border-rose-100 p-2.5 rounded-xl text-center">
                    <span class="block text-[10px] font-medium text-slate-500">Calories</span>
                    <span class="text-sm font-bold text-rose-600">${Math.round(find('Calories'))} kcal</span>
                </div>
                <div class="bg-emerald-50/60 border border-emerald-100 p-2.5 rounded-xl text-center">
                    <span class="block text-[10px] font-medium text-slate-500">Protein</span>
                    <span class="text-sm font-bold text-emerald-600">${Math.round(find('Protein'))} g</span>
                </div>
                <div class="bg-amber-50/60 border border-amber-100 p-2.5 rounded-xl text-center">
                    <span class="block text-[10px] font-medium text-slate-500">Carbs</span>
                    <span class="text-sm font-bold text-amber-600">${Math.round(find('Carbohydrates'))} g</span>
                </div>
                <div class="bg-blue-50/60 border border-blue-100 p-2.5 rounded-xl text-center">
                    <span class="block text-[10px] font-medium text-slate-500">Fats</span>
                    <span class="text-sm font-bold text-blue-600">${Math.round(find('Fat'))} g</span>
                </div>`;

            document.getElementById('modalIngredientsList').innerHTML =
                (recipe.extendedIngredients || []).map(ing =>
                    `<li class="flex items-start gap-2"><i class="fa-solid fa-minus text-[8px] text-amber-500 mt-2"></i> ${ing.original}</li>`
                ).join('');

            const steps = recipe.analyzedInstructions?.[0]?.steps || [];
            document.getElementById('modalInstructionsList').innerHTML = steps.length
                ? steps.map(s => `<li>${s.step}</li>`).join('')
                : `<li>Cooking directions are not structured. Please refer to general cooking safety standards.</li>`;
        }

        function closeModal() {
            const modal          = document.getElementById('recipeModal');
            const modalContainer = modal.querySelector('div');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContainer.classList.remove('scale-100');
            modalContainer.classList.add('scale-95');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('recipeModal');
            if (event.target === modal) closeModal();
        };

        // ─── BOOTSTRAP ───────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('searchBtn').addEventListener('click', () => fetchRecipes(false));
            document.getElementById('randomBtn').addEventListener('click', fetchRandomRecipes);
            document.getElementById('nextBtn').addEventListener('click', slideRight);
            document.getElementById('prevBtn').addEventListener('click', slideLeft);
            document.getElementById('searchInput').addEventListener('keypress', e => {
                if (e.key === 'Enter') fetchRecipes(false);
            });

            fetchRecipes(false);
        });
    </script>