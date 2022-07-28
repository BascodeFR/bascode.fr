import React from 'react'
import Footer from '../layouts/footer';
import Header from '../layouts/header';
import Login from '../layouts/login';
import NavBar from '../layouts/navbar';
import Register from '../layouts/register';


class Layout extends React.Component{
    render(){
        return <><Header connecte=""/> 
        <Login display="hidden"/>
        <Register display="hidden"/>
        <NavBar/>
        {this.props.children}
        <Footer/>
        </>          
    }
}
export default Layout;