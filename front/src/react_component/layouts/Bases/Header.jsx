import React from 'react'
import { useState } from 'react';
import { Link } from 'react-router-dom';
import {Login } from './Login';
import {Register } from './Register';

export function Header(){
    const [logIsActive, setLogActive] = useState(false)
    const toggleLogin = () =>{
        setLogActive(!logIsActive)
    }
    const [regIsActive, setRegActive] = useState(false)
    const Registertoggle = () =>{
        setRegActive(!regIsActive)
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
                        <a onClick={Registertoggle} className="btn">S'inscrire</a>
                    </div>}
                    
                </header>
                
                <Login opacity={logIsActive ? "1" : "0"}/>
                <Register opacity={regIsActive ? "1" : "0"}/></>);
        
}
