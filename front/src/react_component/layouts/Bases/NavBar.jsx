import React from 'react'
import {NavLink} from 'react-router-dom'


export function NavBar() {
        return <nav className="topbar-nav">
                    <div className="nav-content">
                        <NavLink to="/forum"  activeClassName="active" className="nav-items">Forum</NavLink>
                        <NavLink to="/actu" activeClassName="active" className="nav-items">Actualités</NavLink>
                        <NavLink to="/tuto" activeClassName="active" className="nav-items">Tutoriels</NavLink>
                        <NavLink to="/minecraft" activeClassName="active" className="nav-items">Minecraft</NavLink>
                    </div>
                    <div className="research">
                    </div>
                </nav>
}
