import React from 'react'
import { useForm } from "react-hook-form";
import {useNavigate} from "react-router-dom"




export function Login({opacity}) {
    const navigate  = useNavigate()
    const{ register, handleSubmit} = useForm();
    const onSubmit = (data, e) => {
        e.preventDefault()
        if(data.l_password != undefined){
                    fetch('http://localhost:8000/user?name=' + data.l_username + "&password=" + data.l_password, {method: 'POST'}).then((resp) => {
                    if(!resp.ok){
                        throw new Error(resp.error)
                    }
                    return resp.json()}).then((data) => {
                        if(data[0] === "error"){
                            console.log(data[1])
                            sessionStorage.setItem("connecte", "false")
                        } else {
                            sessionStorage.setItem("connecte", "true")
                            console.log(data)
                            sessionStorage.setItem("user", JSON.stringify(data))
                            location.reload();
                        }
                        
                    })
        }
    }
    
        return <div className={opacity === "1" ? "login-pane visible" : "login-pane hidden disp"}>
            <div className="pane">
                <header className="head"></header>
                <h2>Se Connecter</h2>
                <form action="" onSubmit={handleSubmit(onSubmit)} method="post">
                    <div className="fields">
                        <input {...register("l_username")} type="text" name="l_username" id="l_username" required/>
                        <label htmlFor="username">Username ou Email</label>
                    </div>
                    <div className="fields">
                        <input {...register("l_password")} type="text" name="l_password" id="l_password" required/>
                        <label htmlFor="password">Password</label>
                    </div>
                    <div className="check">
                        <input {...register("remember")} type="checkbox" name="remember" id="remember" />
                        <label htmlFor="remember">Se Souvenir de moi</label>
                    </div> 
                    <button type="submit" className="btn">Se Connecter</button>

                </form>
            </div>
        </div>
    }




