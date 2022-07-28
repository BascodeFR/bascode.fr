import React from 'react'

class Header extends React.Component{
    render()
    {
        return <header className="topbar">
                    <div className="logo">
                        <a href="#"><img src="Maquette/logo/bascode.png" alt=""/></a>
                    </div>
                    <div className="connection">
                        <a href="#" className="connect">Utilisateur existant ? Se connecter</a>
                        <a href="#" className="btn">S'inscrire</a>
                    </div>
                </header>;
    }
}

export default Header;