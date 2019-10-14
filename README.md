# WhatTheHack?
This is the main repository of the project WhatTheHack.

## Setup
To run the application, first clone the repository to your local machine:


```bash
git clone https://gitlab.htl-villach.at/whatthehack/whatthehack.git
```

If freshly cloned, a few extra steps are needed:
1. Install the project dependencies: ``` composer install ```
This is what actually installs Laravel itself, among other necessary packages to get started.
2. Install NPM dependencies: ``` npm install ``` or ``` yarn install ```, whatever you prefer.
This will install necessary Javascript (or Node) packages - Vue.js, Bootstrap.css, Lodash and Laravel Mix.
3. Create/Copy the .env file: ``` cp .env.example .env ```
The repository contains a _.env.example_ file which is a template of the _.env_ file the project needs.
4. Generate an app encryption key: ``` php artisan key:generate ```
Laravel requires you to have an app encryption key which is stored in your _.env_ file to encrypt cookies, password hashes and more.
5. Create/Copy a database file.
SQLite databases are valid just by creating a new file called _database.sqlite_ (preferred in the folder _database_). The absolute path then must be added to the _.env_ file to make Laravel use this as the database:
``` DB_DATABASE="C:/Users/Simon/Documents/git/whatthehack/database/database.sqlite" ```

If you have PHP installed locally and you would like to use PHP's built-in development server to serve your application, you may use the serve Artisan command. This command will start a development server at
[localhost:8000](http://localhost:8000):

```
php artisan serve
```

More robust local development options are available via [Homestead](https://laravel.com/docs/5.8/homestead) and [Valet](https://laravel.com/docs/5.8/valet).

The laravel version of this project is `6.0.3`, which is the most recent version of laravel at the moment of installation (09/23/2019). Laravel `6.0` was released on September 3, 2019. Laravel was installed with laravel installer version `v2.1.0`.

The Laravel framework has a few system requirements. All of these requirements are satisfied by the Laravel Homestead virtual machine, so it's highly recommended that you use Homestead as your local Laravel development environment.

However, if you are not using Homestead, you will need to make sure your server meets the following requirements:
- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension


## Contributing

When contributing to this repository, please take in mind that you have to follow our guidelines for contributing. The project language is english, therefore variables, comments, issues and merge request must be written in english langauge only.

**Reference:** Simon Prast <<contact@simonprast.com>>  
Github: [dermrsimon](https://github.com/dermrsimon)  
LinkedIn: [simonprast](https://www.linkedin.com/in/simonprast/)


**Practical advice – Why to consider code standards and care about code quality?**

A goal of code standards is to facilitate monitoring during development of a software product with multiple contributors.

Through this, it will also be possible to provide every developer a fixed, readable code basis with as-low-as-possible overhead. Contributing and merging is only possible in case universal code standards are strictly followed.

### GIT Workflow

#### Issues

For every change carried out, an Issue must exist. Internal developers must always be able to state on which written-down Issue they are currently working.  
[GitLab: Managing Issues](https://docs.gitlab.com/ee/user/project/issues/managing_issues.html)

Issues can be of three types:
- Feature request (New features are expanding the current functionality)
- Change request (Breaking changes affect existing functionality)
- Bug report

#### Working with branches

Once in production, the project is deployed on branch origin master. **Strictly nobody is allowed to directly push on the master branch under no circumstances.**

Each internal developer owns a development branch suited for his requirements (development-[lastname]) in case this is needed. The development branch must be up to date with the master branch to always guarantee compatibility.

For feature development, an own temporary branch is created to completely retrace the development hereafter.

Preferably, a graphical Git client can be used. This helps to ease and speed up the workflow by directly providing an overview over branches, which also helps to avoid mistakes.  
Personally I can recommend [GitKraken](https://www.gitkraken.com/invite/fHs7cbZ9). :)

#### Merge requests

GIT itself provides the possibility for merge requests and code reviews.  
[GitLab: Merge requests](https://docs.gitlab.com/ee/user/project/merge_requests/)

Once one or more features are implemented and tested, a merge request can be created. **A merge request must not be merged into `master` before all implemented features are on production quality and tested.** A merge request must state all changes done since starting of this development branch.

Breaking changes which could affect compatibility for other developers must be clearly stated and communicated throughout the internal developers.

#### Writing commit messages 

Through a commit message, every future developer reading the development history must be able to retrace every single line changed since the last commit.

A commit message must contain **a short, meaningful title line** and **a detailed paragraph**. The paragraph should answer following, if not obvious:
- What exactly is changed?
- Why did you change it?
- How did you implement the change? Were there any complications?

Please try to keep your commits like this:  
![example commit](https://puu.sh/EkoDe/e0e6ceeeaf.png)  
Taken out of [pharmaziegasse/charm-backend](https://github.com/pharmaziegasse/charm-backend/commits/master)

#### Gitignore/Dockerignore files

Developers must not commit any documents, media files, database files, environment files or any other files containing sensible data or being created during production to the GitHub repository.

Every developer is responsible for getting the gitignore file and, if available, also the dockerignore file up to date once a change is implemented which creates one of the above listed file types.
