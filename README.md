## Hotel Booking System Manager

This is a hotel booking system Manager. This application is able to register a new hotel and edit already existing hotels. <br>
&nbsp; &nbsp;Also, Rooms can be created, edited and deleted for any given hotel. Room types for each room can also be specified. <br>
&nbsp; &nbsp;Prices for each room can also be specified. This prices can be edited and deleted.<br>
&nbsp; &nbsp;Rooms in each hotel can be booked. This booking records, can be edited and deleted as well.

### Local Setup

#### API Setup
-   Ensure you have Xampp or Wampp Installed on your local computer.
-   Locate C:/xamppOrWampp/htdocs.
-   Clone this project in the htdocs folder.
-   Navigate to project root in command line e.g. cd c:/xampp/htdocs/{project}.
-   `cp` `.env.example` to `.env` and set your environment variables.
-   Run `Composer Insall` .
-   Run `php artisan serve`.

#### Frontend Setup
-   Ensure you have Node and Angular cli on your local machine.
-   Open command line and navigate to {projectRoot/resources/frontend} e.g. e.g. cd c:/xampp/htdocs/{project}/resources/frontend.
-   Run `npm install` to install app dependencies.
-   Run `ng serve`.


## Testing

-   Follow the instructions in the Local Section Setup Above.
-   Run `php artisan migrate`.
-   Run `php artisan db:seed`.
-   Visit `localhost:4200`.

##### Login Paramters
-   `Email: Johndoe@example.com`
-   `Password: secret`
