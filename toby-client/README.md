# Toby Clone - Client (Vue.js)

This directory contains the **Vue.js frontend** for the Toby Clone. The client handles the user interface, allowing users to manage workspaces, links, and documents seamlessly. It integrates with the Laravel API to provide real-time document organization and collaboration.

---

## Features

- **User-Friendly Interface**: Easily manage and organize workspaces and documents.
- **API Integration**: Full integration with the Laravel backend for workspace and document management.
- **Responsive Design**: Optimized for various screen sizes with responsive layouts.

---

## Tech Stack

- **Vue.js**: Frontend framework for building interactive user interfaces.
- **Tailwind CSS**: Utility-first CSS framework for designing responsive UIs.

---

## Setup Instructions

Follow these steps to set up and run the Vue.js client locally:

1. **Clone the repository** (if you haven’t already):
   ```bash
   git clone https://github.com/hetari/toby.git
   cd toby/toby_client
   ```

2. **Install dependencies**:
   ```bash
   npm install
   ```

3. **Set up environment variables**: 
   
   Create a `.env` file in the root of the `toby_client/` directory with the following content:
   ```bash
   VUE_APP_API_URL=http://localhost:8000  # URL of the Laravel API
   ```

4. **Run the development server**:
   ```bash
   npm run serve
   ```

   This will start the Vue development server at `http://localhost:8080`.

5. **Access the client**: Open your browser and navigate to `http://localhost:8080` to view the application.

---

## Available Scripts

Here are some useful scripts for development and deployment:

- `npm run dev`: Start the development server for local development.
- `npm run build`: Compile and minify the project for production.

---

## Contributing

Contributions are always welcome! Follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a pull request for review.

---

## License

This project is licensed under the MIT License. See the [LICENSE](../LICENSE) file for full details.
