import React from "react";

class Actu extends React.Component{
    render(){
        return <div className="actu-items">
                <img src="https://via.placeholder.com/106x106" alt="" />
                <a href="#" className="actu-name active">Réunion sur la Base de donnée</a>
                <p>Par Cavernos</p>
                <p>Il y a 10 minutes</p>
            </div>
            
    }
}
export default Actu;