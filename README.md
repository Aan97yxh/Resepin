# Resepin — Smart Recipe Discovery Platform

Resepin helps you find recipes based on ingredients you already have, dietary preferences, and allergy restrictions. Powered by the Spoonacular API and built with a secure server-side proxy, it keeps your API key safe while delivering a fast, responsive cooking dashboard.

---

## Features

- **Complex Recipe Search** — Multi-criteria filtering via Spoonacular's `complexSearch` endpoint, cross-referencing query terms, dietary styles, and allergy tolerances in one request.
- **Secure Server-Side Proxy** — All API calls route through a CodeIgniter 4 cURL layer, so your private API key never appears in client-side network traffic.
- **Smart Client-Side Caching** — LocalStorage with TTL mechanics stores macro-nutritional data locally, cutting redundant API calls and preserving quota limits.
- **Dynamic Badge Rendering** — Cards auto-display status badges (Popular, Cheap, Vegetarian, Gluten-Free) based on live recipe data.
- **Clean Responsive UI** — Built with Tailwind CSS, Plus Jakarta Sans, and Playfair Display. Light-mode with subtle micro-interactions throughout.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | CodeIgniter 4 (PHP) |
| Frontend | Vanilla JavaScript (ES6+) & HTML5 |
| Styling | Tailwind CSS (Play CDN) |
| Data Source | Spoonacular API (via cURL) |
| Client Cache | Browser LocalStorage |

---

## 📁 Project Structure

```text
Resepin/
├── app/
│   ├── Config/
│   │   └── Routes.php              # Route definitions (search, random, detail)
│   ├── Controllers/
│   │   ├── Home.php                # Renders the main SPA dashboard
│   │   └── RecipeController.php    # Server-side proxy for Spoonacular API
│   └── Views/
│       ├── layout/
│       │   ├── header.php          # Global meta tags & Tailwind config
│       │   └── footer.php          # State management, caching & modal logic
│       └── recipe_dashboard.php    # View shells & placeholder structures
├── public/
│   └── index.php                   # App entry point
└── .env                            # API credentials (Git-ignored)
```

---

## Installation & Setup

### Prerequisites

- PHP 8.1 or higher
- Apache / XAMPP or the built-in PHP CLI server
- A valid [Spoonacular API Key](https://spoonacular.com/food-api)

### Steps

**1. Clone the repository**

```bash
git clone https://github.com/Aan97yxh/Resepin.git
cd Resepin
```

**2. Create your environment file**

```bash
cp env .env
```

Open `.env` and fill in your credentials:

```ini
CI_ENVIRONMENT = development
app.baseURL    = 'http://localhost:8080/'

SPOONACULAR_API_KEY = "your_actual_spoonacular_api_key_here"
```

**3. Start the development server**

```bash
php spark serve
```

Navigate to **http://localhost:8080** in your browser.

---

## Security Note

API keys are loaded exclusively on the server side through CodeIgniter's environment config. No key is ever exposed in frontend source code or browser network logs.

---

## License

This project is open-source and available under the [MIT License](LICENSE).
