# 🏢 Web Company Profile - Surya Kencana

> Modern company profile website with separate backend (Laravel) and frontend (Vue.js) in a monorepo structure.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=flat&logo=vue.js&logoColor=white)](https://vuejs.org)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker&logoColor=white)](https://www.docker.com)

---

## 📋 Table of Contents

- [Tech Stack](#-tech-stack)
- [Project Structure](#-project-structure)
- [Prerequisites](#-prerequisites)
- [Getting Started](#-getting-started)
  - [1. Clone Repository](#1-clone-repository)
  - [2. Backend Setup](#2-backend-setup)
  - [3. Frontend Setup](#3-frontend-setup)
- [Running the Application](#-running-the-application)
- [Deployment](#-deployment)
- [Environment Variables](#-environment-variables)
- [Contributing](#-contributing)

---

## 🚀 Tech Stack

### Backend
- **Framework**: Laravel 12.x
- **Database**: MySQL 8.x
- **Authentication**: Laravel Sanctum
- **API Documentation**: Swagger (L5-Swagger)
- **Image Processing**: Intervention Image
- **Storage**: AWS S3 / Local

### Frontend
- **Framework**: Vue.js 3.x
- **Build Tool**: Vite
- **Styling**: Tailwind CSS
- **HTTP Client**: Axios
- **State Management**: Pinia (if used)

### DevOps
- **Containerization**: Docker
- **Deployment**: CapRover
- **Secrets Management**: Infisical
- **Version Control**: Git

---

## 📁 Project Structure

```
Web-Company-Profile-Surya-Kencana/
├── be/                          # Backend (Laravel)
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   ├── Dockerfile               # Backend Docker config
│   ├── captain-definition       # CapRover deployment config
│   └── composer.json
│
├── fe/                          # Frontend (Vue.js)
│   ├── src/
│   ├── public/
│   ├── Dockerfile               # Frontend Docker config
│   ├── nginx.conf               # Nginx config for production
│   ├── captain-definition       # CapRover deployment config
│   └── package.json
│
├── user-manual/                 # Documentation (local only)
├── automation/                  # Automation scripts (local only)
└── README.md                    # This file
```

---

## ✅ Prerequisites

Before you begin, ensure you have the following installed:

| Tool | Version | Download |
|------|---------|----------|
| **PHP** | 8.4+ | [php.net](https://www.php.net/downloads) |
| **Composer** | 2.x | [getcomposer.org](https://getcomposer.org) |
| **Node.js** | 20.x LTS | [nodejs.org](https://nodejs.org) |
| **npm** | 10.x+ | (included with Node.js) |
| **MySQL** | 8.x | [mysql.com](https://dev.mysql.com/downloads/) |
| **Infisical CLI** | Latest | [infisical.com](https://infisical.com/docs/cli/overview) |
| **Git** | Latest | [git-scm.com](https://git-scm.com) |

### Optional (for deployment)
- **Docker** (for containerization)
- **CapRover** (for production deployment)

---

## 🎯 Getting Started

### 1. Clone Repository

```bash
git clone https://github.com/hafidzrizqullahprasetya/Web-Company-Profile-Surya-Kencana.git
cd Web-Company-Profile-Surya-Kencana
```

---

### 2. Backend Setup

#### Step 1: Navigate to Backend Directory
```bash
cd be
```

#### Step 2: Install Dependencies
```bash
composer install
```

#### Step 3: Configure Infisical

> **Note**: This project uses **Infisical** for environment variable management instead of `.env` files.

1. **Login to Infisical**:
   ```bash
   infisical login
   ```

2. **Verify Connection**:
   ```bash
   infisical secrets
   ```

   You should see environment variables like `DB_HOST`, `DB_DATABASE`, etc.

#### Step 4: Database Setup

**Option A: Using Infisical (Recommended)**

The database connection is already configured via Infisical. Just run migrations:

```bash
infisical run -- php artisan migrate --seed
```

**Option B: Manual Setup**

If you prefer using `.env` file:

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and configure your database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webcompro
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run migrations:
```bash
php artisan migrate --seed
```

#### Step 5: Generate API Documentation (Optional)
```bash
php artisan l5-swagger:generate
```

---

### 3. Frontend Setup

#### Step 1: Navigate to Frontend Directory
```bash
cd ../fe  # From root: cd fe
```

#### Step 2: Install Dependencies
```bash
npm install
```

#### Step 3: Configure Environment

Create `.env` file (or use `.env.local` for local development):

```bash
cp .env.example .env
```

Edit `.env`:
```env
VITE_API_BASE_URL=http://localhost:8000/api
VITE_CDN_URL=http://localhost:8000
VITE_GOOGLE_MAPS_API_KEY=your_google_maps_api_key
```

---

## 🏃 Running the Application

### Backend (Laravel)

**With Infisical** (Recommended):
```bash
cd be
composer run dev
```

This will start:
- Laravel development server on `http://localhost:8000`
- Laravel Pail (real-time logs)

**Without Infisical**:
```bash
cd be
php artisan serve --host=0.0.0.0 --port=8000
```

### Frontend (Vue.js)

```bash
cd fe
npm run dev
```

This will start Vite dev server on `http://localhost:5173`

### Access the Application

- **Frontend**: http://localhost:5173
- **Backend API**: http://localhost:8000/api
- **API Documentation**: http://localhost:8000/api/documentation

---

## 🚢 Deployment

This project is configured for deployment on **CapRover** using Docker.

### Deployment Architecture

```
GitHub Repository (main branch)
    ↓
CapRover (2 separate apps)
    ├── Backend App  → Uses be/captain-definition
    └── Frontend App → Uses fe/captain-definition
```

### CapRover Setup

#### Backend App Configuration
1. **Method**: Deploy from GitHub
2. **Repository**: `https://github.com/hafidzrizqullahprasetya/Web-Company-Profile-Surya-Kencana`
3. **Branch**: `main`
4. **captain-definition path**: `be/captain-definition`

#### Frontend App Configuration
1. **Method**: Deploy from GitHub
2. **Repository**: `https://github.com/hafidzrizqullahprasetya/Web-Company-Profile-Surya-Kencana`
3. **Branch**: `main`
4. **captain-definition path**: `fe/captain-definition`

### Deployment Workflow

1. **Make changes** in `dev` branch
2. **Test locally**
3. **Merge to `main`**:
   ```bash
   git checkout main
   git merge dev
   git push origin main
   ```
4. **Trigger deployment** in CapRover (click "Force Build")

---

## 🔐 Environment Variables

### Backend (via Infisical)

Required environment variables managed by Infisical:

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_NAME` | Application name | `Laravel` |
| `APP_ENV` | Environment | `production` |
| `APP_KEY` | Laravel encryption key | `base64:...` |
| `APP_URL` | Backend URL | `https://becompro.fizualstd.my.id` |
| `DB_HOST` | Database host | `mysql.fizualstd.my.id` |
| `DB_PORT` | Database port | `10805` |
| `DB_DATABASE` | Database name | `webcompro` |
| `DB_USERNAME` | Database user | `root` |
| `DB_PASSWORD` | Database password | `***` |
| `R2_ACCESS_KEY_ID` | Cloudflare R2 access key | `***` |
| `R2_BUCKET` | R2 bucket name | `fizualstd` |
| `R2_ENDPOINT` | R2 endpoint | `https://...` |

### Frontend

| Variable | Description | Example |
|----------|-------------|---------|
| `VITE_API_BASE_URL` | Backend API URL | `https://becompro.fizualstd.my.id/api` |
| `VITE_CDN_URL` | CDN URL for assets | `https://cdn.fizualstd.my.id` |
| `VITE_GOOGLE_MAPS_API_KEY` | Google Maps API key | `AIza...` |

---

## 🤝 Contributing

### Branching Strategy

- `main` - Production-ready code
- `dev` - Development branch (default for new features)
- Feature branches: `feature/feature-name`
- Bugfix branches: `fix/bug-name`

### Workflow

1. **Create a new branch** from `dev`:
   ```bash
   git checkout dev
   git pull origin dev
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes** and commit:
   ```bash
   git add .
   git commit -m "feat: add new feature"
   ```

3. **Push to GitHub**:
   ```bash
   git push origin feature/your-feature-name
   ```

4. **Create Pull Request** to `dev` branch

5. **After review and merge**, delete feature branch:
   ```bash
   git branch -d feature/your-feature-name
   ```

### Commit Message Convention

Follow [Conventional Commits](https://www.conventionalcommits.org/):

- `feat:` - New feature
- `fix:` - Bug fix
- `docs:` - Documentation changes
- `style:` - Code style changes (formatting, etc.)
- `refactor:` - Code refactoring
- `test:` - Adding tests
- `chore:` - Maintenance tasks

---

## 📞 Support

For questions or issues, please contact:

- **Email**: hafidzrizqullahprasetya@mail.ugm.ac.id
- **GitHub Issues**: [Create an issue](https://github.com/hafidzrizqullahprasetya/Web-Company-Profile-Surya-Kencana/issues)

---

## 📄 License

This project is proprietary and confidential.

---

<div align="center">
  <p>Made with ❤️ by Surya Kencana Team</p>
  <p>© 2025 PT Surya Kencana Jaya Abadi. All rights reserved.</p>
</div>
