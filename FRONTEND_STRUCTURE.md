# Frontend Folder Structure Guide

## Recommended Folder Structures

### Option 1: React + Vite + TypeScript (Recommended)

```
feedback-frontend/
├── public/
│   ├── favicon.ico
│   └── index.html
├── src/
│   ├── api/
│   │   ├── client.ts              # Axios instance & API config
│   │   ├── auth.ts               # Auth API calls
│   │   ├── clients.ts            # Clients API calls
│   │   ├── projects.ts           # Projects API calls
│   │   ├── feedbacks.ts          # Feedbacks API calls
│   │   └── publicFeedback.ts     # Public feedback API calls
│   ├── components/
│   │   ├── common/
│   │   │   ├── Button.tsx
│   │   │   ├── Input.tsx
│   │   │   ├── Select.tsx
│   │   │   ├── Textarea.tsx
│   │   │   ├── Modal.tsx
│   │   │   ├── Table.tsx
│   │   │   ├── Pagination.tsx
│   │   │   ├── SearchBar.tsx
│   │   │   ├── LoadingSpinner.tsx
│   │   │   ├── ErrorMessage.tsx
│   │   │   └── SuccessMessage.tsx
│   │   ├── layout/
│   │   │   ├── MainLayout.tsx     # Authenticated pages layout
│   │   │   ├── AuthLayout.tsx     # Login/Register layout
│   │   │   ├── PublicLayout.tsx   # Public feedback form layout
│   │   │   ├── Sidebar.tsx
│   │   │   └── Header.tsx
│   │   └── forms/
│   │       ├── LoginForm.tsx
│   │       ├── RegisterForm.tsx
│   │       ├── ClientForm.tsx
│   │       └── ProjectForm.tsx
│   ├── pages/
│   │   ├── auth/
│   │   │   ├── LoginPage.tsx
│   │   │   └── RegisterPage.tsx
│   │   ├── dashboard/
│   │   │   └── DashboardPage.tsx
│   │   ├── clients/
│   │   │   ├── ClientsListPage.tsx
│   │   │   ├── CreateClientPage.tsx
│   │   │   ├── EditClientPage.tsx
│   │   │   └── ClientDetailsPage.tsx
│   │   ├── projects/
│   │   │   ├── ProjectsListPage.tsx
│   │   │   ├── CreateProjectPage.tsx
│   │   │   ├── EditProjectPage.tsx
│   │   │   └── ProjectDetailsPage.tsx
│   │   ├── feedbacks/
│   │   │   └── FeedbacksListPage.tsx
│   │   └── public/
│   │       └── PublicFeedbackPage.tsx
│   ├── hooks/
│   │   ├── useAuth.ts             # Authentication hook
│   │   ├── useClients.ts          # Clients data hook
│   │   ├── useProjects.ts         # Projects data hook
│   │   ├── useFeedbacks.ts        # Feedbacks data hook
│   │   └── useDebounce.ts         # Debounce hook for search
│   ├── store/
│   │   ├── authStore.ts           # Auth state (Zustand/Redux)
│   │   └── index.ts
│   ├── types/
│   │   ├── auth.types.ts
│   │   ├── client.types.ts
│   │   ├── project.types.ts
│   │   ├── feedback.types.ts
│   │   └── api.types.ts
│   ├── utils/
│   │   ├── constants.ts           # App constants
│   │   ├── helpers.ts             # Helper functions
│   │   ├── validation.ts          # Validation schemas
│   │   └── formatDate.ts          # Date formatting
│   ├── context/
│   │   └── AuthContext.tsx         # Auth context (if using Context API)
│   ├── App.tsx
│   ├── main.tsx
│   └── router.tsx                 # React Router setup
├── .env
├── .env.example
├── .gitignore
├── package.json
├── tsconfig.json
├── vite.config.ts
└── tailwind.config.js             # If using Tailwind
```

---

### Option 2: Next.js (App Router) - Full Stack Option

```
feedback-frontend/
├── app/
│   ├── (auth)/
│   │   ├── login/
│   │   │   └── page.tsx
│   │   └── register/
│   │       └── page.tsx
│   ├── (dashboard)/
│   │   ├── layout.tsx             # Authenticated layout
│   │   ├── page.tsx               # Dashboard
│   │   ├── clients/
│   │   │   ├── page.tsx           # Clients list
│   │   │   ├── create/
│   │   │   │   └── page.tsx
│   │   │   ├── [id]/
│   │   │   │   ├── page.tsx       # Client details
│   │   │   │   └── edit/
│   │   │   │       └── page.tsx
│   │   ├── projects/
│   │   │   ├── page.tsx           # Projects list
│   │   │   ├── create/
│   │   │   │   └── page.tsx
│   │   │   ├── [id]/
│   │   │   │   ├── page.tsx       # Project details
│   │   │   │   └── edit/
│   │   │   │       └── page.tsx
│   │   └── feedbacks/
│   │       └── page.tsx
│   └── feedback/
│       └── [token]/
│           └── page.tsx            # Public feedback form
├── components/
│   ├── ui/                        # Reusable UI components
│   ├── forms/                     # Form components
│   └── layout/                    # Layout components
├── lib/
│   ├── api/                       # API functions
│   ├── utils/                     # Utility functions
│   └── hooks/                     # Custom hooks
├── types/                         # TypeScript types
├── store/                         # State management
├── public/
├── .env.local
├── next.config.js
├── package.json
└── tsconfig.json
```

---

### Option 3: Vue.js + Vite + TypeScript

```
feedback-frontend/
├── public/
├── src/
│   ├── api/
│   │   ├── index.ts               # Axios instance
│   │   ├── auth.api.ts
│   │   ├── clients.api.ts
│   │   ├── projects.api.ts
│   │   └── feedbacks.api.ts
│   ├── components/
│   │   ├── common/
│   │   ├── layout/
│   │   └── forms/
│   ├── views/
│   │   ├── auth/
│   │   │   ├── LoginView.vue
│   │   │   └── RegisterView.vue
│   │   ├── dashboard/
│   │   │   └── DashboardView.vue
│   │   ├── clients/
│   │   │   ├── ClientsListView.vue
│   │   │   ├── CreateClientView.vue
│   │   │   ├── EditClientView.vue
│   │   │   └── ClientDetailsView.vue
│   │   ├── projects/
│   │   │   ├── ProjectsListView.vue
│   │   │   ├── CreateProjectView.vue
│   │   │   ├── EditProjectView.vue
│   │   │   └── ProjectDetailsView.vue
│   │   ├── feedbacks/
│   │   │   └── FeedbacksListView.vue
│   │   └── public/
│   │       └── PublicFeedbackView.vue
│   ├── stores/
│   │   ├── auth.ts                # Pinia store
│   │   └── index.ts
│   ├── router/
│   │   └── index.ts               # Vue Router
│   ├── composables/
│   │   ├── useAuth.ts
│   │   ├── useClients.ts
│   │   └── useProjects.ts
│   ├── types/
│   ├── utils/
│   ├── App.vue
│   └── main.ts
├── package.json
├── vite.config.ts
└── tsconfig.json
```

---

## Recommended Structure (React + Vite)

### Detailed Breakdown:

#### `/src/api/` - API Layer
- Centralized API calls
- Axios instance with interceptors
- Token management
- Error handling

#### `/src/components/` - Reusable Components
- **common/**: Shared UI components (Button, Input, Modal, etc.)
- **layout/**: Layout components (Sidebar, Header, MainLayout)
- **forms/**: Form components (LoginForm, ClientForm, etc.)

#### `/src/pages/` - Page Components
- Organized by feature/domain
- Each page is a route
- Contains page-specific logic

#### `/src/hooks/` - Custom Hooks
- Reusable logic
- Data fetching hooks
- Business logic hooks

#### `/src/store/` - State Management
- Global state (auth, user preferences)
- Using Zustand or Redux Toolkit

#### `/src/types/` - TypeScript Types
- Type definitions for all entities
- API response types
- Form types

#### `/src/utils/` - Utility Functions
- Helper functions
- Constants
- Validation schemas

---

## Best Practices

### 1. **Feature-Based Organization** (Alternative)
Instead of grouping by type, you can organize by feature:

```
src/
├── features/
│   ├── auth/
│   │   ├── components/
│   │   ├── hooks/
│   │   ├── api/
│   │   ├── types/
│   │   └── pages/
│   ├── clients/
│   │   ├── components/
│   │   ├── hooks/
│   │   ├── api/
│   │   ├── types/
│   │   └── pages/
│   └── projects/
│       ├── components/
│       ├── hooks/
│       ├── api/
│       ├── types/
│       └── pages/
├── shared/
│   ├── components/
│   ├── hooks/
│   ├── utils/
│   └── types/
└── App.tsx
```

**Pros**: Better for large teams, easier to find related code
**Cons**: Can lead to code duplication

### 2. **Type-Based Organization** (Recommended for this project)
Group by file type (components, pages, hooks, etc.)

**Pros**: Clear separation, easy to understand
**Cons**: Can be harder to find feature-specific code

---

## File Naming Conventions

- **Components**: PascalCase (`ClientCard.tsx`, `ProjectForm.tsx`)
- **Hooks**: camelCase with `use` prefix (`useAuth.ts`, `useClients.ts`)
- **Utils**: camelCase (`formatDate.ts`, `validation.ts`)
- **Types**: camelCase with `.types.ts` suffix (`client.types.ts`)
- **API files**: camelCase with `.api.ts` or `.ts` (`clients.api.ts`)
- **Pages**: PascalCase with `Page` suffix (`ClientsListPage.tsx`)

---

## Environment Variables

Create `.env` file:

```env
VITE_API_BASE_URL=http://public.test/api
VITE_APP_NAME=Feedback Management System
```

---

## Recommended Structure for This Project

**I recommend Option 1 (React + Vite + TypeScript)** because:
1. ✅ Most popular and well-documented
2. ✅ Great TypeScript support
3. ✅ Fast development with Vite
4. ✅ Large ecosystem
5. ✅ Easy to find developers
6. ✅ Good for API-driven applications

**Folder Structure**: Type-based organization (as shown in Option 1)

---

## Quick Start Commands

### React + Vite:
```bash
npm create vite@latest feedback-frontend -- --template react-ts
cd feedback-frontend
npm install
npm install axios zustand react-router-dom
npm install -D tailwindcss postcss autoprefixer
```

### Next.js:
```bash
npx create-next-app@latest feedback-frontend --typescript --tailwind --app
cd feedback-frontend
npm install axios zustand
```

### Vue.js:
```bash
npm create vite@latest feedback-frontend -- --template vue-ts
cd feedback-frontend
npm install
npm install axios pinia vue-router
npm install -D tailwindcss postcss autoprefixer
```

---

## Summary

**Best Structure for This Project:**
- **Framework**: React + Vite + TypeScript
- **Organization**: Type-based (components/, pages/, hooks/, etc.)
- **State Management**: Zustand (lightweight)
- **Routing**: React Router
- **HTTP Client**: Axios
- **Styling**: Tailwind CSS (already in backend)

This structure is:
- ✅ Easy to understand
- ✅ Scalable
- ✅ Maintainable
- ✅ Follows industry standards
