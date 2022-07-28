import React from 'react'

class CardContainer extends React.Component{
    render(){
        const className = "cards " + this.props.className
        if(this.props.name == 'Dernières Actualités') {
            return <div className={className}> <header className="cards-head">{this.props.name}</header>
             {this.props.children} 
             
             </div>; 
        } else {
            return  <div className={className}> <header className="cards-head">{this.props.name}</header>{this.props.children} </div>;
        }         
    }
}

export default CardContainer;
