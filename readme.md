## Application overview

1. Sign in

![signin](https://user-images.githubusercontent.com/36139351/54079131-fb835b80-4308-11e9-94f4-f48888380d1a.png) 

2. Sign Up

![signup](https://user-images.githubusercontent.com/36139351/54079129-faeac500-4308-11e9-8a51-b4d5a1990430.png)

3. Home

![home](https://user-images.githubusercontent.com/36139351/54079130-fb835b80-4308-11e9-94c1-80d80d40f5f5.png)

## Api Route

Base Url = https://timelineapi.derazu.tech/

| Type | Link | Info | 
|------|------|------|
| get | user | get all user account |
| post | user | register user account, param: name, email, username, password |
| post | user/login | login user, param: username, password |
| get | timeline/{id} | get all timeline with user id |
| post | timeline | add timeline based on user id, param: user_id, title, date, content |
| post | timeline/{id} | edit timeline based on timeline id, param: user_id, content, date, title |
| delete | timeline/{id} | delete timeline based on timeline id |

## Authors

* **M. Panji Wiramanik** - (https://github.com/panjiwiramanik)