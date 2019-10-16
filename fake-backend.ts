import { Http, BaseRequestOptions, Response, ResponseOptions, RequestMethod } from '@angular/http';
import { MockBackend, MockConnection } from '@angular/http/testing';

export let fakeBackendProvider = {
    
    provide: Http,
    useFactory: (backend: MockBackend, options: BaseRequestOptions) => {
       
        let users: any[] = JSON.parse(localStorage.getItem('users')) || [];

      
        backend.connections.subscribe((connection: MockConnection) => {
       
            setTimeout(() => {

                // authenticate
                if (connection.request.url.endsWith('/api/authenticate') && connection.request.method === RequestMethod.Post) {
                    // get parameters from post request
                    let params = JSON.parse(connection.request.getBody());

                    // find if any user matches login credentials
                    let filteredUsers = users.filter(user => {
                        return user.username === params.username && user.password === params.password;
                    });

                    if (filteredUsers.length) {
                      
                        let user = filteredUsers[0];
                        connection.mockRespond(new Response(new ResponseOptions({
                            status: 200,
                            body: {
                                id: user.id,
                                username: user.username,
                                firstName: user.firstName,
                                lastName: user.lastName,
                                token: 'fake-jwt-token'
                            }
                        })));
                    } else {
                        
                        connection.mockError(new Error('Username or password is incorrect'));
                    }
                }

                // get users
                if (connection.request.url.endsWith('/api/users') && connection.request.method === RequestMethod.Get) {
                   
                    if (connection.request.headers.get('Authorization') === 'Bearer fake-jwt-token') {
                        connection.mockRespond(new Response(new ResponseOptions({ status: 200, body: users })));
                    } else {
                      
                        connection.mockRespond(new Response(new ResponseOptions({ status: 401 })));
                    }
                }

                // get user by id
                if (connection.request.url.match(/\/api\/users\/\d+$/) && connection.request.method === RequestMethod.Get) {
                    // check for fake auth token in header and return user if valid, this security is implemented server side in a real application
                    if (connection.request.headers.get('Authorization') === 'Bearer fake-jwt-token') {
                        // find user by id in users array
                        let urlParts = connection.request.url.split('/');
                        let id = parseInt(urlParts[urlParts.length - 1]);
                        let matchedUsers = users.filter(user => { return user.id === id; });
                        let user = matchedUsers.length ? matchedUsers[0] : null;

                        
                        connection.mockRespond(new Response(new ResponseOptions({ status: 200, body: user })));
                    } else {
                       
                        connection.mockRespond(new Response(new ResponseOptions({ status: 401 })));
                    }
                }

                // create user
                if (connection.request.url.endsWith('/api/users') && connection.request.method === RequestMethod.Post) {
                    // get new user object from post body
                    let newUser = JSON.parse(connection.request.getBody());

                    // validation
                    let duplicateUser = users.filter(user => { return user.username === newUser.username; }).length;
                    if (duplicateUser) {
                        return connection.mockError(new Error('Username "' + newUser.username + '" is already taken'));
                    }

                    // save new user
                    newUser.id = users.length + 1;
                    users.push(newUser);
                    localStorage.setItem('users', JSON.stringify(users));

                   
                    connection.mockRespond(new Response(new ResponseOptions({ status: 200 })));
                }

                // delete user
                if (connection.request.url.match(/\/api\/users\/\d+$/) && connection.request.method === RequestMethod.Delete) {
                   
                    if (connection.request.headers.get('Authorization') === 'Bearer fake-jwt-token') {
                        // find user by id in users array
                        let urlParts = connection.request.url.split('/');
                        let id = parseInt(urlParts[urlParts.length - 1]);
                        for (let i = 0; i < users.length; i++) {
                            let user = users[i];
                            if (user.id === id) {
                                // delete user
                                users.splice(i, 1);
                                localStorage.setItem('users', JSON.stringify(users));
                                break;
                            }
                        }

                        // respond 200 OK
                        connection.mockRespond(new Response(new ResponseOptions({ status: 200 })));
                    } else {
                        // return 401 not authorised if token is null or invalid
                        connection.mockRespond(new Response(new ResponseOptions({ status: 401 })));
                    }
                }

            }, 500);

        });

        return new Http(backend, options);
    },
    deps: [MockBackend, BaseRequestOptions]
};