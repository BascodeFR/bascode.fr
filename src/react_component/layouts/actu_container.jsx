import React from "react";

class ActuContainer extends React.Component{
    render(){
        return  <div className="actus">
            <div className="prev"><a href='#'className="prev-button"></a></div>
            {this.props.children}
            <div className="next"><a href='#'className="next-button"></a></div>
            
        </div>
            
    }
}
export default ActuContainer;