import React from 'react'

class Footer extends React.Component{
    render()
    {
        return <footer className="footer">
        <div className="copyright">
            Copyright 2022
        </div>
        <div className="socials">
            <a href="https://github.com/BascodeFR" target="_blank" className="github"></a>
            <a href="#" className ="discord"></a>
        </div>
    </footer>
    }
}

export default Footer;