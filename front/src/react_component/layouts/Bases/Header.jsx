import React from 'react'
import { useState } from 'react';
import { Login } from './Login';

export function Header({connecte}){
    const [isActive, setActive] = useState(false)
    const toggleLogin = () =>{
        setActive(!isActive)
    }
            return (<><header className="topbar">
                    <div className="logo">
                        <a href="/"><img src="/src/assets/img/bascode.png" alt=""/></a>
                    </div>
                    {connecte === "true" ? <div className="account">
                            <div className="msg"></div>
                                <img src="https://via.placeholder.com/40x40" alt="" />
                            <div className="username">Cavernos</div>
                        </div> : 
                
                    <div className="connection">
                        <a onClick={toggleLogin} className="connect">Utilisateur existant ? Se connecter</a>
                        <a href="#" className="btn">S'inscrire</a>
                    </div>}
                    
                </header>
                <Login opacity={isActive ? "1" : "0"}/></>);
        
}
