import React from 'react'

export function CardContainer({name, CssClass, children}) {
        const classProps = "cards " + CssClass
        if(name == 'Dernières Actualités') {
            return <div className={classProps}> <header className="cards-head">{name}</header>
             {children} 
             
             </div>; 
        } else {
            return  <div className={classProps}> <header className="cards-head">{name}</header>{children} </div>;
        }         
}
