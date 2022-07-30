import React from "react";

export function ActuContainer({children}){
        return  <div className="actus">
            <div className="prev"><a href='#'className="prev-button"></a></div>
            {children}
            <div className="next"><a href='#'className="next-button"></a></div>
            
        </div>        
}