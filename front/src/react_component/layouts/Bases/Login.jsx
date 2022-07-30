import React from 'react'
export function Login({display}) {
        return <div className={"login-pane " + display}>
            <div className="pane">
                <header className="head"></header>
                <h2>Se Connecter</h2>
                <form action="" method="post">
                    <div className="fields">
                        <input type="text" name="l_username" id="l_username" required/>
                        <label htmlFor="username">Username ou Email</label>
                    </div>
                    <div className="fields">
                        <input type="text" name="l_password" id="l_password" required/>
                        <label htmlFor="password">Password</label>
                    </div>
                    <div className="check">
                        <input type="checkbox" name="remember" id="remember" />
                        <label htmlFor="remember">Se Souvenir de moi</label>
                    </div> 
                    <button type="submit" className="btn">Se Connecter</button>

                </form>
            </div>
        </div>
    }




