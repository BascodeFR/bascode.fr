import React from 'react'
class NavBar extends React.Component{
    render()
    {
        return <nav className="topbar-nav">
                    <div className="nav-content">
                        <a href="#"  className="nav-items">Forums</a>
                        <a href="#" className="nav-items active">Actualités</a>
                        <a href="#" className="nav-items">Tutoriels</a>
                        <a href="#" className="nav-items">Minecraft</a>
                    </div>
                    <div className="research">
                        
                    </div>
                </nav>
    }
    
}
export default NavBar; 
