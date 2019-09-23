# WhatTheHack?
This is the main repository of the project WhatTheHack.

## Setup
To run the application, first clone the repository to your local machine:


```bash
git clone https://github.com/whatthehack-at/whatthehack.git
```


If you have PHP installed locally and you would like to use PHP's built-in development server to serve your application, you may use the serve Artisan command. This command will start a development server at
[localhost:8000](http://localhost:8000):

```
php artisan serve
```

More robust local development options are available via [Homestead](https://laravel.com/docs/5.8/homestead) and [Valet](https://laravel.com/docs/5.8/valet).

The laravel version of this project is `6.0.3`, which is the most recent version of laravel at the moment of installation (09/23/2019). Laravel `6.0` was released on September 3, 2019. Laravel was installed with laravel installer version `v2.1.0`.

## Contributing

When contributing ot this repository, please take in mind that you have to follow our guidelines for contributing.

**Reference:** Simon Prast <<contact@simonprast.com>>  
Github: [dermrsimon](https://github.com/dermrsimon)  
LinkedIn: [simonprast](https://www.linkedin.com/in/simonprast/)


**Practical advice – Why to consider code standards and care about code quality?**

A goal of code standards is to facilitate monitoring during development of a software product with multiple contributors.

Through this, it will also be possible to provide every developer a fixed, readable code basis with as-low-as-possible overhead. Contributing and merging is only possible in case universal code standards are strictly followed.

### GIT Workflow

#### Issues

For every change carried out, an Issue must exist. Internal developers must always be able to state on which written-down Issue they are currently working.  
[Github: Creating an Issue](https://help.github.com/en/articles/creating-an-issue)

Issues can be of three types:
- Feature request (New features are expanding the current functionality)
- Change request (Breaking changes affect existing functionality)
- Bug report

#### Working with branches

Once in production, the project is deployed on branch origin master. **Strictly nobody is allowed to directly push on the master branch under no circumstances.**

Each internal developer owns a development branch suited for his requirements. The development branch must be up to date with the master branch to always guarantee compatibility.

For feature development, an own temporary branch is created to completely retrace the development hereafter.

Preferably, a graphical Git client can be used. This helps to ease and speed up the workflow by directly providing an overview over branches, which also helps to avoid mistakes.  
Personally I can recommend [GitKraken](https://www.gitkraken.com/invite/fHs7cbZ9). :)

#### Pull requests

GIT itself provides the possibility for pull requests and code reviews.  
[GitHub: About pull requests](https://help.github.com/en/articles/about-pull-requests)

Once one or more features are implemented and tested, a pull request can be created. **A pull request must not be merged into `master` before all implemented features are on production quality and tested.** A pull request must state all changes done since starting of this development branch.

Breaking changes which could affect compatibility for other developers must be clearly stated and communicated throughout the internal developers.

#### Writing commit messages 

Through a commit message, every future developer reading the development history must be able to retrace every single line changed since the last commit.

A commit message must contain **a short, meaningful title line** and **a detailed paragraph**. The paragraph should answer following, if not obvious:
- What exactly is changed?
- Why did you change it?
- How did you implement the change? Where there any complications?

Please try to keep your commits like this:  
![alt text](https://puu.sh/EkoDe/e0e6ceeeaf.png)  
Taken out of [pharmaziegasse/charm-backend](https://github.com/pharmaziegasse/charm-backend/commits/master)

#### Gitignore/Dockerignore files

Developers must not commit any documents, media files, database files, environment files or any other files containing sensible data or being created during production to the GitHub repository.

Every developer is responsible for getting the gitignore file and, if available, also the dockerignore file up to date once a change is implemented which creates one of the above listed file types.
