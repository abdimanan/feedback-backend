# Frontend Pages Structure

## Overview
This document outlines all the pages needed for the Feedback Backend frontend application.

---

## Total Pages: **12 Pages**

### 🔐 Authentication Pages (2 pages)

#### 1. **Login Page** (`/login`)
- **Purpose**: User authentication
- **Features**:
  - Email and password input
  - Login form
  - Error handling
  - Redirect to dashboard after successful login
- **API Endpoint**: `POST /api/login`
- **Access**: Public (unauthenticated users)

#### 2. **Register Page** (`/register`)
- **Purpose**: Register new users (Admin only)
- **Features**:
  - Name, email, password, password confirmation inputs
  - Role selection (Admin or Project Manager)
  - Form validation
  - Success message
- **API Endpoint**: `POST /api/register`
- **Access**: Admin only (requires authentication)
- **Note**: This can be a modal/dialog instead of a full page

---

### 🏠 Dashboard Pages (1 page)

#### 3. **Dashboard/Home Page** (`/` or `/dashboard`)
- **Purpose**: Main landing page after login
- **Features**:
  - Overview statistics (total clients, projects, feedbacks)
  - Recent activity feed
  - Quick actions (Create Client, Create Project)
  - Navigation to main sections
- **Access**: Authenticated users only

---

### 👥 Client Management Pages (4 pages)

#### 4. **Clients List Page** (`/clients`)
- **Purpose**: Display all clients with search and pagination
- **Features**:
  - Table/list of clients (name, email, description)
  - Search functionality (by name, email, description)
  - Pagination (15 per page)
  - "Create Client" button
  - Edit and Delete actions for each client
  - View client details
- **API Endpoint**: `GET /api/clients?search=&per_page=15`
- **Access**: Authenticated users

#### 5. **Create Client Page** (`/clients/create`)
- **Purpose**: Create a new client
- **Features**:
  - Form with fields: Name, Email, Description (optional)
  - Form validation
  - Submit button
  - Cancel/Back button
- **API Endpoint**: `POST /api/clients`
- **Access**: Authenticated users

#### 6. **Edit Client Page** (`/clients/:id/edit`)
- **Purpose**: Update an existing client
- **Features**:
  - Pre-filled form with existing data
  - Same fields as Create Client
  - Update and Cancel buttons
- **API Endpoints**: 
  - `GET /api/clients/:id` (to load data)
  - `PUT /api/clients/:id` (to update)
- **Access**: Authenticated users

#### 7. **Client Details Page** (`/clients/:id`)
- **Purpose**: View client details and related projects
- **Features**:
  - Client information display
  - List of projects for this client
  - Edit and Delete buttons
  - Back to clients list
- **API Endpoint**: `GET /api/clients/:id`
- **Access**: Authenticated users

---

### 📁 Project Management Pages (4 pages)

#### 8. **Projects List Page** (`/projects`)
- **Purpose**: Display all projects with search, filter, and pagination
- **Features**:
  - Table/list of projects (name, description, client, start date)
  - Search functionality (by project name, description, or client info)
  - Filter by client (dropdown)
  - Pagination (15 per page)
  - "Create Project" button
  - Actions: View, Edit, Delete, Generate Feedback Link
- **API Endpoint**: `GET /api/projects?search=&client_id=&per_page=15`
- **Access**: Authenticated users

#### 9. **Create Project Page** (`/projects/create`)
- **Purpose**: Create a new project
- **Features**:
  - Form with fields: Client (dropdown), Name, Description, Start Date
  - Client selection dropdown (populated from clients API)
  - Form validation
  - Submit and Cancel buttons
- **API Endpoint**: `POST /api/projects`
- **Access**: Authenticated users

#### 10. **Edit Project Page** (`/projects/:id/edit`)
- **Purpose**: Update an existing project
- **Features**:
  - Pre-filled form with existing data
  - Same fields as Create Project
  - Update and Cancel buttons
- **API Endpoints**:
  - `GET /api/projects/:id` (to load data)
  - `PUT /api/projects/:id` (to update)
- **Access**: Authenticated users

#### 11. **Project Details Page** (`/projects/:id`)
- **Purpose**: View project details and manage feedback links
- **Features**:
  - Project information display
  - Client information
  - "Generate Feedback Link" button
  - Display generated feedback links (if any)
  - List of feedbacks for this project
  - Edit and Delete buttons
  - Back to projects list
- **API Endpoints**:
  - `GET /api/projects/:id` (project details)
  - `POST /api/projects/:id/feedback-link` (generate link)
  - `GET /api/feedbacks?project_id=:id` (project feedbacks)
- **Access**: Authenticated users

---

### 💬 Feedback Pages (1 page)

#### 12. **Feedbacks List Page** (`/feedbacks`)
- **Purpose**: View all feedbacks with filtering
- **Features**:
  - Table/list of feedbacks
  - Filter by Client (dropdown)
  - Filter by Project (dropdown)
  - Display: Project name, Client name, Ratings, Likes/Dislikes text, Overall rating, Date
  - Pagination (15 per page)
  - View feedback details (modal or expandable row)
- **API Endpoint**: `GET /api/feedbacks?client_id=&project_id=&per_page=15`
- **Access**: Authenticated users

---

### 🌐 Public Pages (1 page - separate from main app)

#### 13. **Public Feedback Form Page** (`/feedback/:token`)
- **Purpose**: Allow clients to submit feedback using a token (no login required)
- **Features**:
  - Token validation (check if valid, not expired, not used)
  - Feedback form with:
    - Statement 1 Rating (1-5)
    - Statement 2 Rating (1-5)
    - Statement 3 Rating (1-5)
    - Likes text (textarea)
    - Dislikes text (textarea, optional)
    - Overall Rating (1-5)
  - Form validation
  - Success message after submission
  - Error messages for invalid/expired/used tokens
- **API Endpoint**: `POST /api/public/feedback/:token`
- **Access**: Public (no authentication required)
- **Note**: This should be a separate, simple page with minimal styling

---

## Additional Components Needed

### Reusable Components:
1. **Navigation/Sidebar** - Main navigation menu
2. **Header** - Top bar with user info and logout
3. **Search Bar** - Reusable search component
4. **Pagination** - Reusable pagination component
5. **Modal/Dialog** - For confirmations, forms, details
6. **Form Inputs** - Text, Email, Select, Textarea, Date, Rating
7. **Table** - Reusable data table component
8. **Loading Spinner** - Loading state indicator
9. **Error Message** - Error display component
10. **Success Message** - Success notification

### Layout Components:
1. **Main Layout** - Wrapper for authenticated pages
2. **Auth Layout** - Wrapper for login/register pages
3. **Public Layout** - Wrapper for public feedback form

---

## User Roles & Permissions

### Admin:
- ✅ All features accessible
- ✅ Can register new users
- ✅ Full CRUD on Clients, Projects, Feedbacks

### Project Manager:
- ✅ Can view and manage Clients, Projects, Feedbacks
- ✅ Can generate feedback links
- ❌ Cannot register new users

---

## API Base URL
- **Development**: `http://public.test/api`
- **Production**: Update based on your production URL

---

## Recommended Tech Stack

### Frontend Framework Options:
1. **React** + **Vite** + **TypeScript**
2. **Vue.js** + **Vite** + **TypeScript**
3. **Next.js** (if you want SSR)
4. **Laravel + Inertia.js** (if you want to stay in Laravel ecosystem)

### UI Library Options:
1. **Tailwind CSS** (already in backend)
2. **Shadcn/ui** (for React)
3. **Vuetify** (for Vue)
4. **Ant Design**
5. **Material UI**

### State Management:
1. **Zustand** (lightweight)
2. **Redux Toolkit**
3. **Pinia** (for Vue)
4. **React Query / TanStack Query** (for data fetching)

### HTTP Client:
1. **Axios**
2. **Fetch API**
3. **Laravel Sanctum** (for authentication)

---

## Page Flow Diagram

```
Login → Dashboard
  ↓
  ├─→ Clients List → Create Client / Edit Client / Client Details
  ├─→ Projects List → Create Project / Edit Project / Project Details → Generate Feedback Link
  └─→ Feedbacks List

Public: /feedback/:token → Submit Feedback Form
```

---

## Summary

**Total Pages: 13 pages**
- 2 Authentication pages
- 1 Dashboard page
- 4 Client management pages
- 4 Project management pages
- 1 Feedback list page
- 1 Public feedback form page

**Estimated Development Time:**
- Small team (1-2 developers): 3-4 weeks
- Solo developer: 6-8 weeks

**Priority Order:**
1. Authentication (Login)
2. Dashboard
3. Clients Management
4. Projects Management
5. Feedbacks List
6. Public Feedback Form
7. Register (Admin only)
