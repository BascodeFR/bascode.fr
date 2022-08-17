import React from 'react'
import { useState } from 'react';
import { Link } from 'react-router-dom';
import {Login } from './Login';

export function Header({connecte}){
    const [isActive, setActive] = useState(false)
    const toggleLogin = () =>{
        setActive(!isActive)
    }
    let user = null
    if (sessionStorage.user != undefined){
        user = JSON.parse(sessionStorage.user)
    }
    
            return (<><header className="topbar">
                    <div className="logo">
                        <a href="/"><img src="/src/assets/img/bascode.png" alt=""/></a>
                    </div>
                    {window.sessionStorage.getItem("connecte") === "true"  ? <div className="account">
                            <Link to="/msg" className="msg"></Link>
                                <img src="https://via.placeholder.com/40x40" alt="" />
                            <div className="username">{user.username}</div>
                        </div> : 
                
                    <div className="connection">
                        <a onClick={toggleLogin} className="connect">Utilisateur existant ? Se connecter</a>
                        <a href="#" className="btn">S'inscrire</a>
                    </div>}
                    
                </header>
                
                <Login opacity={isActive ? "1" : "0"}/></>);
        
}
