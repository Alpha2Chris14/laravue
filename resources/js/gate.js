export default class Gate{
    
    constructor(user="administrator"){
        this.user = user;
    }

    isAdmin(){
        return this.authorize("administrator");
    }

    isUser(){
        return this.authorize("user");
    }

    isRegular(){
        return this.authorize("regular");
    }

    authorize(value){
        // console.log("User: "+this.user)
        // console.log("user value"+value);
        return this.user == value;

    }
}