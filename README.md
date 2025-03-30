# CAR Laravel Application

## Introduction
The **Corrective Action Report (CAR) Laravel Application** is a web-based system designed to facilitate the management and tracking of corrective action reports. This application streamlines the flow of reports from managers to field personnel and ensures timely notifications through email alerts.

## Features
- **Document Uploading**: Users can upload relevant documents and attach them to corrective action reports.
- **Report Flow**: Managers can create, review, and assign corrective action reports to field personnel.
- **Email Notifications**: Automatic email alerts notify users about new reports, status updates, and pending actions.

## Installation
To install and set up the application, follow these steps:

### Prerequisites
Ensure you have the following installed:
- PHP 8.x
- Composer
- Laravel 10.x
- MySQL or PostgreSQL database
- Node.js & npm (for frontend assets)

### Steps
1. Clone the repository:
   ```sh
   git clone https://github.com/yourusername/car-laravel-app.git
   cd car-laravel-app
   ```
2. Install dependencies:
   ```sh
   composer install
   npm install && npm run dev
   ```
3. Copy the environment file and set up configurations:
   ```sh
   cp .env.example .env
   ```
   Update the `.env` file with database and mail configurations.
4. Generate application key:
   ```sh
   php artisan key:generate
   ```
5. Run migrations and seed the database:
   ```sh
   php artisan migrate --seed
   ```
6. Start the application:
   ```sh
   php artisan serve
   ```

## Usage

### Uploading Documents
- Users can attach supporting documents when creating a corrective action report.
- Uploaded files are stored securely and can be accessed by relevant personnel.

### Corrective Action Report Flow
1. **Manager Creates Report**: A manager logs in and creates a corrective action report.
2. **Assigns to Field Personnel**: The report is assigned to a responsible field member.
3. **Updates & Resolutions**: Field personnel updates the status and uploads necessary documentation.
4. **Review & Closure**: Managers review the report and close it once resolved.

### Email Notifications
- Users receive email alerts when:
  - A new report is assigned to them.
  - A report is updated or commented on.
  - A report is marked as resolved.

## API Endpoints
| Method | Endpoint | Description |
|--------|---------|-------------|
| POST | `/api/reports` | Create a new corrective action report |
| GET | `/api/reports` | Fetch all reports |
| GET | `/api/reports/{id}` | Fetch a specific report |
| PUT | `/api/reports/{id}` | Update a report |
| DELETE | `/api/reports/{id}` | Delete a report |
| POST | `/api/reports/{id}/upload` | Upload documents to a report |

## Contributing
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature-name`).
3. Commit your changes (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature-name`).
5. Open a pull request.

## License
This project is licensed under the MIT License.

## Contact
For any inquiries, please reach out to **edwinkiuma.com** or create an issue in the repository.
CAR Website App <a>https://car.betterglobeforestry.com </a>


