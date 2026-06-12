<?= view('layout/header') ?>

<div class="max-w-6xl mx-auto px-4 py-12 space-y-16">

    <!-- ================= SECTION 1: HERO SECTION ================= -->
    <section class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
        <!-- Left Side: Header & Introduction -->
        <div class="md:col-span-7 space-y-5 text-left">
            <span class="text-xs font-bold tracking-widest text-amber-600 uppercase bg-amber-100/80 px-3 py-1 rounded-full">Spoonacular Powered</span>
            <h1 class="serif-title text-5xl md:text-6xl font-black text-slate-950 leading-tight pt-2">
                This is Resepin.<br><span class="text-amber-500">Enjoy!</span>
            </h1>
            <p class="text-sm md:text-base text-slate-600 leading-relaxed max-w-xl">
                Welcome to our smart recipe discovery platform. Explore thousands of culinary ideas tailored beautifully to your unique taste and dietary preferences. Whether you are a beginner or a seasoned home cook, we make kitchen exploration safe, intuitive, and full of flavor.
            </p>
        </div>

        <!-- Right Side: Food Showcase -->
        <div class="md:col-span-5 flex justify-center">
            <div class="relative w-72 h-72 md:w-80 md:h-80 rounded-full overflow-hidden shadow-xl border-4 border-white/90">
                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=600" alt="Fresh Healthy Meal" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-amber-50/10 via-transparent to-transparent"></div>
            </div>
        </div>
    </section>

    <!-- ================= PRE-FILTER SECTION ================= -->
    <section class="space-y-8 max-w-5xl mx-auto">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-950 tracking-tight">Tailor Your Recipe Feed</h2>
            <p class="text-xs md:text-sm text-slate-500 leading-relaxed">Customize your dynamic choices and avoid specific food allergies before running your recipe search engine</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card 1: Food Allergies -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 space-y-4 hover:shadow-md transition-shadow flex flex-col justify-between">
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-slate-950 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-400"></i> Food Allergies
                    </h3>
                    <p class="text-xs text-slate-500">Exclude ingredients that you are sensitive or allergic to</p>
                </div>
                <div class="flex flex-wrap gap-2 pt-2">
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Peanut</button>
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Dairy</button>
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Seafood</button>
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Gluten</button>
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Soy</button>
                </div>
            </div>

            <!-- Card 2: Dietary Preferences -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 space-y-4 hover:shadow-md transition-shadow flex flex-col justify-between">
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-slate-950 flex items-center gap-2">
                        <i class="fa-solid fa-heart text-emerald-400"></i> Dietary Preferences
                    </h3>
                    <p class="text-xs text-slate-500">Select nutritional lifestyles that match your body profile standards</p>
                </div>
                <div class="flex flex-wrap gap-2 pt-2">
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Vegan</button>
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Keto</button>
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Paleo</button>
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Mediterranean</button>
                    <button onclick="toggleChip(this)" class="chip px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-all cursor-pointer">Low-Carb</button>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= SECTION 2: SEARCH HUB ================= -->
    <section class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-3xl mx-auto w-full">
        <div class="relative flex-1 w-full shadow-sm rounded-full">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input id="searchInput" type="text" placeholder="Search recipes, dishes, ingredients..."
                class="w-full pl-12 pr-6 py-3.5 rounded-full bg-white border border-slate-200 focus:outline-none focus:border-amber-400 focus:ring-4 focus:ring-amber-100/60 text-sm transition-all shadow-inner">
        </div>
        <button id="searchBtn" onclick="handleSearch()"
            class="w-full sm:w-auto px-6 py-3.5 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold text-sm shadow-md hover:shadow-orange-200/50 hover:shadow-lg active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap">
            <i class="fa-solid fa-magnifying-glass"></i> Find Recipes
        </button>
        <button id="randomBtn" onclick="handleRandom()"
            class="w-full sm:w-auto px-6 py-3.5 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold text-sm shadow-md hover:shadow-orange-200/50 hover:shadow-lg active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap">
            <i class="fa-solid fa-shuffle"></i> Random Recipe
        </button>
    </section>

    <!-- ================= SECTION 3: RECIPE CAROUSEL ================= -->
    <section class="space-y-6 relative">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Explore Recipes</h2>
                <p class="text-xs text-slate-500">Curated top selection matching your criteria constraints</p>
            </div>
            <div class="flex items-center gap-2">
                <button id="prevBtn" onclick="scrollLeftCarousel()" class="w-9 h-9 rounded-full bg-white shadow-sm border border-slate-200 hover:bg-slate-50 active:scale-90 flex items-center justify-center text-slate-600 transition-all opacity-50 cursor-not-allowed" disabled>
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button id="nextBtn" onclick="scrollRightCarousel()" class="w-9 h-9 rounded-full bg-white shadow-sm border border-slate-200 hover:bg-slate-50 active:scale-90 flex items-center justify-center text-slate-600 transition-all cursor-pointer">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Error / Empty State Message -->
        <div id="emptyState" class="hidden text-center py-10">
            <p class="text-slate-500 text-sm">Oops, those ingredients are a bit too unique! Try removing or swapping a few of them, and we'll do our best to find a matching recipe.</p>
        </div>

        <!-- Carousel Grid -->
        <div class="overflow-hidden py-2 -mx-2 px-2">
            <div id="carouselContainer" class="grid grid-cols-1 md:grid-cols-3 gap-6 transition-all duration-500 ease-out">

                <!-- Skeleton Loaders -->
                <div id="skeletonLoader1" class="hidden bg-white/40 border border-slate-200/60 rounded-2xl p-4 space-y-4 animate-pulse">
                    <div class="bg-slate-200 h-36 rounded-xl w-full"></div>
                    <div class="h-4 bg-slate-200 rounded w-2/3"></div>
                    <div class="h-3 bg-slate-200 rounded w-1/2"></div>
                </div>
                <div id="skeletonLoader2" class="hidden bg-white/40 border border-slate-200/60 rounded-2xl p-4 space-y-4 animate-pulse">
                    <div class="bg-slate-200 h-36 rounded-xl w-full"></div>
                    <div class="h-4 bg-slate-200 rounded w-3/4"></div>
                    <div class="h-3 bg-slate-200 rounded w-1/3"></div>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- ================= MODAL RECIPE OVERLAY ================= -->
<div id="recipeModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 p-4">
    <div id="modalCard" class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[85vh] overflow-y-auto transform scale-95 transition-transform duration-300 flex flex-col">

        <!-- Modal Header -->
        <div class="sticky top-0 bg-white/95 backdrop-blur-md px-6 py-4 border-b border-slate-100 flex items-center justify-between z-10">
            <h3 id="modalRecipeTitle" class="font-bold text-base md:text-lg text-slate-950">Loading...</h3>
            <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-rose-100 text-slate-500 hover:text-rose-600 transition-colors flex items-center justify-center cursor-pointer">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-6">
            <div class="h-60 rounded-xl overflow-hidden shadow-inner">
                <img id="modalRecipeImage" src="" alt="" class="w-full h-full object-cover">
            </div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-600 bg-amber-50 px-3 py-1.5 rounded-lg w-fit">
                <i class="fa-regular fa-clock text-amber-500"></i>
                <span>Preparation Time: <strong id="modalPrepTime" class="text-slate-900">—</strong></span>
            </div>
            <div class="space-y-3">
                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-pie"></i> Nutrition Facts
                    <span class="text-[10px] font-normal capitalize">(per serving)</span>
                </h4>
                <div id="modalNutritionGrid" class="grid grid-cols-2 sm:grid-cols-4 gap-2.5"></div>
            </div>
            <hr class="border-slate-100">
            <div class="space-y-2">
                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-layer-group"></i> Ingredients
                </h4>
                <ul id="modalIngredientsList" class="space-y-1.5 text-xs md:text-sm text-slate-600 pl-1"></ul>
            </div>
            <hr class="border-slate-100">
            <div class="space-y-2">
                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-list-ol"></i> Instructions
                </h4>
                <ol id="modalInstructionsList" class="space-y-3 text-xs md:text-sm text-slate-600 list-decimal pl-4 leading-relaxed"></ol>
            </div>
        </div>

    </div>
</div>

<?= view('layout/footer') ?>
