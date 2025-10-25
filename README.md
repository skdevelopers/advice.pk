# 🏡 Advice AI Real Estate CRM

**Smart Property Intelligence for the Modern Market**

> Built with **Laravel 12**, **PHP 8.4**, **PostgreSQL + PostGIS**, and powered by **AI/ML models** for trend analysis, buyer insights, and predictive property valuation.

---

## 🚀 Overview

**Advice AI Real Estate CRM** is a next-generation property management and analytics platform designed for real estate professionals, agents, and investors.  
It goes beyond listings — combining **AI-driven market insights**, **buyer behavior modeling**, and **trend forecasting** to help users make smarter, faster, and data-backed real estate decisions.

---

## 🧠 Core Features

### 🏘️ Real Estate CRM
- Manage properties, agents, and clients with ease
- Multi-society, multi-sector structure with **dynamic property features**
- Integrated **media library** with optimized image handling
- Seamless CRUD using **Axios + Blade + Alpine.js**

### 🤖 AI-Powered Analytics
- AI/ML models for **buyer trend analysis** and **property value prediction**
- Auto-generated **SEO content and meta tags**
- Smart **AI recommendation engine** for investors and agents

### 📊 Market & Trend Intelligence
- Detect hot zones and trending sectors with **AI clustering**
- Real-time **demand-supply graphs**
- Predictive analytics for **price movement & buyer sentiment**

### 🗺️ PostGIS Spatial Intelligence
- Geo-tagging & mapping with **PostGIS**
- Advanced spatial queries for **radius-based property search**
- Zone heatmaps for visual analysis

### 💡 Optimized Architecture
- Modular Laravel 12 architecture
- **AIService & AISeoManager** for centralized intelligence
- **Media Library (Spatie)** for responsive image optimization
- Centralized **Toast Notifications** with Alpine.js
- Designed for **scalability**, **speed**, and **SEO-first performance**

---

## 🧩 Tech Stack

| Layer | Technology |
|-------|-------------|
| **Backend** | PHP 8.4, Laravel 12 |
| **Database** | PostgreSQL 16 with PostGIS extension |
| **Frontend** | Blade, TailwindCSS, Alpine.js, Axios |
| **AI/ML** | Laravel-integrated Python microservices for predictive analytics |
| **Storage** | DigitalOcean Spaces / S3 Compatible |
| **Search** | PostgreSQL Full-Text Search / Vector Embeddings |
| **Real-time** | Redis + Laravel Echo / WebSockets |
| **Deployment** | Docker + Nginx + Supervisor + Queue Workers |
| **Version Control** | Git / GitHub CI/CD |
| **OS** | Ubuntu 24.04 (Optimized for Droplets) |

---

## ⚙️ Installation

```bash
# 1️⃣ Clone Repository
git clone https://github.com/skdevelopers/advice.pk.git
cd advice.pk

# 2️⃣ Install Dependencies
composer install
npm install && npm run build

# 3️⃣ Setup Environment
cp .env.example .env
php artisan key:generate

# 4️⃣ Configure Database
# Update .env with PostgreSQL credentials and PostGIS extension

# 5️⃣ Run Migrations
php artisan migrate --seed

# 6️⃣ Optimize Application
php artisan optimize:clear
php artisan storage:link

# 7️⃣ Serve
php artisan serve
