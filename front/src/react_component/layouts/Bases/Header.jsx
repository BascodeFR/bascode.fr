import React from 'react'

export function Header({connecte}){
            return (<header className="topbar">
                    <div className="logo">
                        <a href="/"><img src="/src/assets/img/bascode.png" alt=""/></a>
                    </div>
                    {connecte === "true" ? <div className="account">
                            <div className="msg"></div>
                                <img src="https://via.placeholder.com/40x40" alt="" />
                            <div className="username">Cavernos</div>
                        </div> : <div className="connection">
                        <a href="#" className="connect">Utilisateur existant ? Se connecter</a>
                        <a href="#" className="btn">S'inscrire</a>
                    </div>}
                </header>);
        
}
