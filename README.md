# UUWG WordPress Theme

Кастомна блочна тема (FSE) для Union of Ukrainian Women in Greece.

## Структура

```
uuwg-theme/
├── style.css              — заголовок теми (обов'язковий)
├── theme.json              — дизайн-токени: кольори, шрифти, spacing
├── functions.php           — точка входу, підключає /inc/
├── inc/
│   ├── setup.php            — theme supports, меню, pattern category
│   ├── enqueue.php          — підключення CSS/JS
│   ├── cpt-projects.php     — CPT Projects + таксономія Featured/Past
│   ├── cpt-news.php         — CPT News & Events
│   ├── cpt-documents.php    — CPT Documents + таксономія Рік
│   ├── cpt-team.php         — CPT Team members
│   ├── cpt-partners.php     — CPT Partners
│   ├── acf-options.php      — ACF Options Page (глобальні налаштування)
│   └── blocks.php           — авто-реєстрація блоків з /blocks/
├── blocks/                  — кастомні блоки (створювати по одному, з ТЗ ≈10 шт.)
│   └── {block-name}/
│       ├── block.json
│       ├── render.php
│       └── style.css
├── templates/                — Block Templates (front-page, page-*, single-*)
├── parts/                    — Template Parts (header, footer, contact-section)
├── patterns/                 — Block Patterns (опційно, для повторних наборів блоків)
└── acf-json/                 — авто-синхронізація ACF-полів (з'явиться після першого поля)
```

## Старт локально

1. `wp theme activate uuwg-theme` (або через адмінку Appearance → Themes)
2. Активувати плагіни: ACF (Pro), Polylang, Fluent Forms, MC4WP
3. ACF → Tools → Sync — підтягнути поля з `acf-json/`, якщо вони вже є в репозиторії
4. Заповнити ACF Options Page (`/wp-admin/admin.php?page=uuwg-settings`)

## Наступні кроки розробки

Дивись план з 11 етапів — зараз готові кроки 1–3 (середовище, theme.json, header/footer-скелет)
і каркас 4–7 (CPT зареєстровані, шаблони-заглушки готові, блоки треба наповнити реальною
розміткою й ACF-полями один за одним, від простих до складних).

## Кольори в theme.json

Значення HEX у палітрі — **плейсхолдери**. Заміни на точні через Figma dev mode
(inspect → Code → CSS) перед тим, як почнеш верстати перший блок.
