import React from 'react'
import {NavLink} from 'react-router-dom'


export function NavBar() {
        return <nav className="topbar-nav">
                    <div className="nav-content">
                        <NavLink to="/forum" className={({isActive}) => (isActive ? "nav-items active" : 'nav-items')}>Forum</NavLink>
                        <NavLink to="/actu" className={({isActive}) => (isActive ? "nav-items active" : 'nav-items')}>Actualités</NavLink>
                        <NavLink to="/tuto" className={({isActive}) => (isActive ? "nav-items active" : 'nav-items')}>Tutoriels</NavLink>
                        <NavLink to="/minecraft" className={({isActive}) => (isActive ? "nav-items active" : 'nav-items')}>Minecraft</NavLink>
                    </div>
                    <div className="research">
                    </div>
                </nav>
}
