import React from "react";

class TopicMessage extends React.Component{
    render(){
        return  <div className="messages-content">
            <h2>Cavernos</h2>
            <div className="user-info">
                <img src="https://via.placeholder.com/55x55" alt="" />
                <p>Admin</p>
            </div>
            <div className="msg-head"><p>Posté le 23 février</p><div className="author"><p>Auteur</p></div></div>
            <div className="content">J'ai un bug avec sql  <br /> <br /> <img src="https://via.placeholder.com/560x270" alt="" /> <br /> <br /></div>
        </div>
            
    }
}
export default TopicMessage;