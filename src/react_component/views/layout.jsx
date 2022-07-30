import React from 'react'
import {Footer} from '../layouts/Bases/Footer';
import {Header} from '../layouts/Bases/Header';
import {Login} from '../layouts/Bases/Login';
import {Register} from '../layouts/Bases/Register';
import {NavBar} from '../layouts/Bases/NavBar';



export function Layout(props) {
        return <><Header connecte="true"/> 
        <Login display="hidden"/>
        <Register display="hidden"/>
        <NavBar/>
        {props.children}
        <Footer/>
        </>          
}