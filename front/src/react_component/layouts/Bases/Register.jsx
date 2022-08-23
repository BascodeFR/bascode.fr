import React from 'react'
export function Register({opacity}){
        return <div className={opacity === "1" ? "register visible" : "register hidden disp"}>
            <div className="pane">
                <header className="head"></header>
                <h2>S'inscrire</h2>
                <hr />
                <form action="" method="post">
                    <div className="fields">
                        <input type="text" name="name" id="name" required/>
                        <label htmlFor="name">Nom Complet</label>
                    </div>
                    <div className="fields">
                        <input type="text" name="username" id="r_username" required/>
                        <label htmlFor="r_username">Username</label>
                    </div>
                    <div className="fields">
                        <input type="email" name="email" id="email" required/>
                        <label htmlFor="email">Email</label>
                    </div>
                    <div className="fields">
                        <input type="password" name="r_password" id="r_password" required/>
                        <label htmlFor="r_password">Mot de Passe</label>
                    </div>
                    <div className="fields">
                        <input type="password" name="passwordConf" id="passwordConf" required/>
                        <label htmlFor="passwordConf">Confirmation du Mot de Passe</label>
                    </div>
                    <div className="check">
                        <input type="checkbox" name="cond" id="cond" />
                        <label htmlFor="cond">Accepter les condition d'utilisation</label>
                    </div> 
                    <button type="submit" className="btn">Créer mon compte</button>

                </form>
            </div>
        </div>
}