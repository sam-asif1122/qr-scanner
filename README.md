<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Development
The current project has package [laravel/sail](https://packagist.org/packages/laravel/sail) installed.
Steps to get a working development env:
1. Copy the **.env.example** file and change the value of the environment variables needed
```
$ cp .env.example .env
```
2. Install required packager
```
# Using docker
$ docker run -it --rm -v $(pwd):/var/www/html -w /var/www/html/ composer install
# Or manually
$ composer install
```
3. Build the required containers used by the app
```
$ ./vendor/bin/sail build
```
3. Start up the containers
```
$ ./vendor/bin/sail up -d
```
4. Check the [sail doc](https://laravel.com/docs/10.x/sail) for more commands to run.
5. Generate the **APP_KEY** variable value
```
$ ./vendor/bin/sail artisan key:generate
```
6. Run the migrations
```
$ ./vendor/bin/sail artisan migrate
```

## Flow of Application Implemented
- Flow of Application starts as the user vists the website, he will be shown a page to upload a file/document,
- For uploading the document or file, user is required to Login
- After login, user will be able to see his dashboard where he can see statistics of all the documents he has uploaded and their statuses.
- Scanning and decoding the QR code functionality is protected by auth middleware on root url so that a user must be logged in before uploading.
- When a document is uploaded, its QR code is scanned using the package and is decoded and saved as content with a submission being created.
- A record is created for the document in the documents table when a submission is created successfully.
- A user submissions are listed in a table.
- A user can `view` the QR code from the uploaded file along with the decoded content.
- A user can `edit` the submission by uploading and Scanning the document again.
- A user can `delete` the submission.
- User should be authorized for only his submissions when performing any action.
- During document uploading, the enum status for the submission will be `Processing` and will be updated to `Processed` when the document is uploaded and submission is created. It will be saved as an `Error` submission when the document is failed to be uploaded.

## Code changes and added configurations
- A form is added to upload the QR image to get content decoded.
-  To decode the QR code into content, A package is installed [qrcode-detector-decoder](https://github.com/khanamiryan/php-qrcode-detector-decoder) :
   `composer require khanamiryan/qrcode-detector-decoder`.
- Corresponding Routes and Controllers are added for the above functionalities.
- Submission `request rules` are defined with error handling and errors are displayed on the form.
- A field `content` is added in the `submissions` table through a migration to store the decoded QR content.
- A field `document_name` is added in the `documents` table to store the filename that is uploaded.
- `Traits` are used to slim the controller and perform upload processing logic in store and update actions of submission.
- `Gates` are used to authorize the user to access their own submissions for any kind of action.
- `Dashboard` is enhanced using cards to display the statistics of the user submissions.

## Increasing Application Extensibility
To ensure extensibility and handle increased usage in your application's architecture, you can consider the following approaches:
#### Scaling the Application Servers:
As the usage of your application increases, you can horizontally scale your application servers. This means adding more servers to distribute the load across multiple instances of your application. By using a load balancer, you can evenly distribute incoming requests among these servers, increasing the application's capacity to handle more traffic.
#### Queueing System:
By using a queueing system, such as Laravel's built-in queueing mechanism or a dedicated message broker like RabbitMQ or Apache Kafka, you can decouple time-consuming or resource-intensive tasks from the request-response cycle. Instead of processing the submission synchronously, you can push the task to a queue, allowing it to be processed by one or more worker processes in the background. This helps to ensure that your application remains responsive and can handle more concurrent requests.
#### Worker Processes:
In the context of Laravel, you can create separate worker processes that listen to the queue and process the jobs asynchronously. These workers can be run on separate servers or instances to handle the queued tasks. By increasing the number of worker processes or scaling them horizontally, you can handle a higher volume of tasks concurrently.
#### Database Scaling:
As the usage of your application increases, you may need to scale your database to handle the increased load. This can be achieved by vertical scaling (upgrading the server hardware) or horizontal scaling (sharding or replication). Vertical scaling involves increasing the resources (CPU, memory, storage) of the existing database server, while horizontal scaling involves distributing the database across multiple servers.
#### Caching:
Implementing caching mechanisms can help reduce the load on the application servers and improve response times. By caching frequently accessed data or computationally expensive results, you can serve the data directly from the cache instead of querying the database or performing costly computations.
#### Infrastructure-as-Code and Containerization:
By using infrastructure-as-code tools like Terraform or containerization platforms like Docker and Kubernetes, you can automate the provisioning and scaling of your infrastructure. This makes it easier to manage and deploy multiple instances of your application, allowing for more flexibility and scalability.
These are some architectural considerations to handle increased usage and ensure the extensibility of your application. The specific approach will depend on various factors such as the nature of your application, expected usage patterns, available resources, and performance requirements. It's important to analyze and monitor the application's performance regularly to identify any bottlenecks and make appropriate adjustments to the architecture as needed.
