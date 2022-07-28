import React from 'react'


class Container extends React.Component{
    render(){
        return  <main className="container">
                    <a href="#">{this.props.view}</a>
                    {this.props.children}
        
        </main>             
    }
}
export default Container;