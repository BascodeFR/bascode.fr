import React from 'react'
import { Paginations } from '../Topics/Pagination'

export function CardContainer({name, CssClass, children}) {
        const classProps = "cards " + CssClass
            return <>{name === 'Dernières Actualités' ? <div className={classProps}> <header className="cards-head">{name}</header>{children}
             
             </div> : <div className={classProps}> <header className="cards-head">{name}</header>{children}</div>} 
             </>    
}
