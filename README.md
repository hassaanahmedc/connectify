## About Connectify

Connectify is a social media platform engineered to move past basic tutorial apps and handle real-world data relationships, cloud-ready deployment environments, and strict server-side authorization.

___

## System Architecture & Tech Stack

This application utilizes a decoupled cloud infrastructure to ensure high performance and data isolation:

* **Backend Framework:** Laravel (PHP) utilizing Service Classes, Traits, Notifications, Models and Dependency Injection.
* **Frontend Reactivity:** Vanilla JS, Alpine.js paired with Tailwind CSS for lightweight, non-blocking UI state.
* **Database Layer:** Powered by a **TiDB Serverless cluster** with environment-aware SSL configurations.
* **Media Offloading:** Decoupled entirely from the local server, all user media is processed asynchronously via the **Cloudinary API**.
* **Deployment:** Production-verified via a containerized environment on Railway to ensure cloud-readiness and secure environment variable management.

___

## My Hardest Engineering Challenges in this project

### The Problem: Race Conditions in Frontend Reactivity
I implemented a global notification system designed to provide asynchronous feedback from backend processes (e.g., "Profile picture deleted"). My initial implementation used purely Alpine.js window event listeners (`@...window`).
On complex pages with multiple interactive elements, unpredictable component initialization order caused a critical flaw: **race conditions where event listeners failed to attach before events were fired.**

### The Architectural Solution
To solve this, I re-architected the frontend ecosystem to better align with separation of concerns:
1.  **Embracing Local State:** Alpine.js components were refactored to strictly manage only their own local UI state (e.g., whether a dropdown is open or closed), respecting its strengths as a DOM-centric tool.
2.  **Decoupled Event Bus:** I built a simple, global Event Bus in vanilla JavaScript. This created a highly reliable, explicit channel for broadcasting application-wide events like API success or failure.
3.  **"Smart" vs. "Dumb" Components:** The notification component was re-designed as a self-contained, "smart" listener, leaving the triggering UI elements as simple, "dumb" event dispatchers.

> **Result:** Alpine handles the local UI display, and the vanilla JavaScript event bus handles the *how*...

___

## Core Features of Connectify

* **Dynamic Discovery Engine:** Employs a custom proximity query based on location columns to rank and recommend connections to the authenticated user.
* **Social Connection Matrix:** Built on a robust **many-to-many relationship schema** in MySQL to handle fluid follow/unfollow states asynchronously.
* **Granular Security Policies:** Enforces strict server-side validation via **Laravel Policies**, dynamically rendering critical UI elements (like edit/delete actions) exclusively for authorized content owners.
* **Optimized Performance:** Implemented batched lazy-loading for comments (fetching 5 at a time via targeted API payloads) to keep server memory footprints lightweight.

___

## Local Installation Guide

To get a local instance of this project running on your machine, follow these steps:

### Prerequisites
Ensure you have PHP, Composer, and Node.js/NPM installed on your system.

### 1. Clone the Repository
```bash
git clone https://github.com/hassaanahmedc/connectify.git
cd connectify
```

### 2. Install Dependencies
```bash
composer install
npm install && npm run dev
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```
Open your .env file and configure your local database credentials alongside your Cloudinary API keys.

### 4. Run Migrations & Seeders
```bash
php artisan migrate --seed
```

### 5. Launch the Local Server
```bash
php artisan serve
```
Now Visit http://127.0.0.1:8000 in your browser!

___