# Mood Tracker Application

A web-based mood tracking application built with Laravel that helps users monitor and analyze their daily emotional states. Users can record their moods, add notes, view trends, and track their mood streaks.

## Features

- **Daily Mood Logging**: Record your mood (Happy, Sad, Angry, Excited) with optional notes
- **Mood History**: View and manage your past mood entries
- **Streak Tracking**: Monitor your mood logging consistency with streak counters
- **Weekly Summary**: Visual representation of your mood patterns over the week
- **Monthly Analysis**: Get insights into your most frequent moods
- **Soft Delete**: Safely archive mood entries with the ability to restore them
- **User Authentication**: Secure, phone-based authentication system
- **Mobile Responsive**: Works seamlessly on both desktop and mobile devices

## Setup Instructions

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js and NPM

### Installation

1. Clone the repository
```bash
git clone [your-repository-url]
cd mood_tracker
```
2. Install PHP dependencies
```bash
composer install
```
3. Install Node.js dependencies
```bash
npm install
```
4. Create a .env file and configure your database connection
```bash
cp .env.example .env
```
5. Generate the application key
```bash
php artisan key:generate
```
6. Run database migrations and seeders
```bash
php artisan migrate --seed
```
7. Compile assets
```bash
npm run dev
```
8. Start the development server
```bash
php artisan serve
```
### Configuration

Update the following in your .env file:

```env
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```
## Usage

1. Register an account using your phone number
2. Log in to your account
3. Click "Record Mood" to add a new mood entry
   - Select your mood type (Happy, Sad, Angry, Excited)
   - Add optional notes (up to 1000 characters)
   - Choose the date
4. View your mood history and statistics in the dashboard
   - See your current mood streak
   - Track your mood logging consistency
5. Check your weekly and monthly mood summaries
   - View mood distribution over the week
   - See your most frequent mood of the month
6. Manage your mood entries
   - Edit existing entries
   - Soft delete unwanted entries
   - Restore previously deleted entries

## API Endpoints

### Mood Management
- `GET /moods` - Retrieve all moods for authenticated user
- `POST /moods` - Create a new mood entry
  - Required fields: mood_type, date
  - Optional fields: note
- `GET /moods/{mood}` - Get details of a specific mood
- `PUT /moods/{mood}` - Update an existing mood entry
- `DELETE /moods/{mood}` - Soft delete a mood entry

### Archived Moods
- `GET /moods/trashed` - Get list of soft-deleted moods
- `POST /moods/{mood}/restore` - Restore a soft-deleted mood

### Analytics
- `GET /moods/summary/weekly` - Get mood distribution for current week
  - Returns count by mood type
  - Includes date range
- `GET /moods/stats/month` - Get monthly mood statistics
  - Most frequent mood
  - Total entries
  - Percentage distribution