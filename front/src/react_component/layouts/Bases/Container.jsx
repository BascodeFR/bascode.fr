import React from 'react'


export function Container({view, children}) {
        return  <main className="container">
                    <a href="/">{view[0]}</a>
                    <a href="/forum">{view[1]}</a>
                    <a href="/forum/base-de-donnee-1">{view[2]}</a>
                    {children}
        
                </main>             
}