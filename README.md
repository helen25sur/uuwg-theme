# UUWG — Union of Ukrainian Women in Greece

A custom WordPress website developed for the **Union of Ukrainian Women in Greece (UUWG)** based on a Figma design.

The project was built from scratch as a custom WordPress block theme with a focus on reusable components, structured content management, responsive layouts, dynamic content and a maintainable theme architecture.

## Features

- Custom WordPress block theme
- Full Site Editing (FSE)
- Custom Gutenberg blocks
- Custom Post Types and taxonomies
- Advanced Custom Fields (ACF)
- Custom REST API endpoints
- AJAX filtering and pagination
- Dynamic content loading without page reloads
- Responsive design based on Figma
- Multilingual support with Polylang
- Custom animations with GSAP
- Fluent Forms integration
- Reusable PHP template parts
- Custom WordPress theme architecture

## Tech Stack

- **WordPress**
- **PHP**
- **JavaScript**
- **HTML / CSS**
- **Gutenberg / Full Site Editing**
- **ACF**
- **WordPress REST API**
- **GSAP**
- **Polylang**
- **Fluent Forms**

## Key Technical Work

### Custom WordPress Theme

The website was developed as a custom block theme rather than using a pre-built WordPress theme.

The theme uses reusable Gutenberg blocks, template parts and a modular PHP structure to keep the code maintainable and reusable.

### Dynamic Content

Projects, News & Events and Documents are implemented using Custom Post Types with custom taxonomies and structured fields.

Dynamic content is loaded through custom REST API endpoints. Filtering and pagination are handled asynchronously with JavaScript, allowing content to update without a full page reload.

### Responsive UI

The layouts were implemented from Figma designs for desktop, tablet and mobile breakpoints, with custom responsive behavior for navigation, content grids, filters and interactive elements.

### Animations

GSAP and CSS transitions are used to create subtle UI animations and improve the visual experience without interfering with usability.

## Project Structure

```text
uuwg-theme/
│
├── assets/
│   ├── css/
│   ├── images/
│   └── js/
│
├── blocks/
│   └── custom-blocks/
│
├── inc/
│   ├── acf-options.php
│   ├── ajax-handlers.php
│   ├── blocks.php
│   ├── body-classes.php
│   ├── cpt-documents.php
│   ├── cpt-news.php
│   ├── cpt-partners.php
│   ├── cpt-projects.php
│   ├── cpt-team.php
│   ├── enqueue.php
│   ├── filters.php
│   ├── head.php
│   ├── language-switcher.php
│   ├── pagination.php
│   ├── setup.php
│   ├── shortcodes.php
│   └── template-parts.php
│
├── parts/
├── templates/
├── functions.php
├── style.css
└── theme.json
```

### `inc/` Overview

The `inc/` directory contains the main PHP functionality of the theme:

| File                    | Responsibility                           |
| ----------------------- | ---------------------------------------- |
| `setup.php`             | Theme setup and WordPress features       |
| `blocks.php`            | Custom block registration                |
| `enqueue.php`           | Styles and JavaScript assets             |
| `filters.php`           | REST API endpoints and content filtering |
| `pagination.php`        | Dynamic pagination logic                 |
| `template-parts.php`    | Reusable rendering functions             |
| `cpt-projects.php`      | Projects CPT and taxonomies              |
| `cpt-news.php`          | News & Events CPT                        |
| `cpt-documents.php`     | Documents CPT and taxonomies             |
| `cpt-team.php`          | Team Members CPT                         |
| `cpt-partners.php`      | Partners CPT                             |
| `acf-options.php`       | ACF configuration                        |
| `language-switcher.php` | Language switching functionality         |
| `shortcodes.php`        | Custom shortcodes                        |
| `body-classes.php`      | Custom body classes                      |

## Development

The website was developed from scratch from a Figma design and implemented as a production-oriented custom WordPress theme.

The project demonstrates practical experience with WordPress theme development, PHP, JavaScript, REST APIs, custom content structures, asynchronous UI interactions and responsive frontend implementation.

## Links

- **Live Website:** in future
- **GitHub Repository:** [https://github.com/helen25sur/uuwg-theme](https://github.com/helen25sur/uuwg-theme)

## Project Status

The project is under active development and refinement.

The current implementation includes the core custom theme architecture, dynamic content, REST API endpoints, AJAX filtering, responsive layouts and custom frontend interactions.

## Author

**Olena Surilova**

Web / WordPress Developer

- GitHub: https://github.com/helen25sur
- Portfolio: https://surilova.netlify.app
