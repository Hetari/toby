# Toby Clone

A full-stack application that replicates key features of [Toby](https://www.gettoby.com/), a productivity tool designed to improve team collaboration by organizing and centralizing links and documents. This project features a **Vue.js** client and a **Laravel** API.

## Table of Contents

- [Toby Clone](#toby-clone)
  - [Table of Contents](#table-of-contents)
  - [Project Structure](#project-structure)
  - [Overview](#overview)
  - [Features](#features)
  - [Tech Stack](#tech-stack)
  - [Setup Instructions](#setup-instructions)
    - [Base Setup](#base-setup)
  - [Usage](#usage)
  - [Contributing](#contributing)
  - [License](#license)

---

## Project Structure

```bash
toby/
├── toby_client/      # Vue.js frontend for the application
├── toby_api/         # Laravel backend API
└── README.md         # This README file (base)
```

Each subdirectory has its own README file with specific instructions for setting up the client and API:

1. [Client README](/toby_client/README.md)
2. [API README](/toby_api/README.md)

---

## Overview

The **Toby Clone** project is a full-stack web application that allows users to organize, manage, and share their documents and links in one central location. The system comprises:

1. **Vue.js Client**: A modern, responsive, and interactive interface for managing workspaces and documents.
2. **Laravel API**: A robust backend that handles workspace management, document storage, and user authentication.
3. **Full-Stack Integration**: Seamless integration between the client and API, mimicking the functionality of Toby.

---

## Features

- **Workspaces Organization**: Create and manage workspaces to keep documents neatly organized.
- **Team Collaboration**: Share documents with your team and collaborate in real-time.
- **Centralized Document Management**: Store and access important links and files in one place, reducing the time spent looking for information.
- **User-Friendly Interface**: Intuitive UI for a seamless experience, powered by Vue.js.
- **Efficient Search**: Quickly locate documents within workspaces without wasting time.

---

## Tech Stack

- **Frontend**: Vue.js, Tailwind CSS.
- **Backend**: Laravel (PHP).
- **Database**: MySQL.

---

## Setup Instructions

### Base Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/hetari/toby.git
   cd toby
   ```

2. To run the full application locally, follow the specific setup instructions in each folder's README:

- **Client Setup**: [Client README](./toby_client/README.md) for instructions on setting up the Vue.js client.
- **API Setup**: [API README](./toby_api/README.md) for instructions on setting up the Laravel API.

---

## Usage

Once both the client and API are running:
- **Frontend**: Access the Vue.js client at `http://localhost:8080`.
- **API**: The Laravel API is available at `http://localhost:8000`.

---

## Contributing

Contributions are welcome! If you'd like to improve the project, feel free to:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Submit a pull request.

Please make sure to follow proper coding practices, including writing clear and concise commit messages, and adhere to the project's existing code style.

---

## License

This project is licensed under the MIT License. For more details, see the [LICENSE](./LICENSE) file.
