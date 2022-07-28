import React from 'react'



class TopicResponse extends React.Component{
    render(){
        return  <div className="resp">
            <h2>Rejoindre la conversation</h2>
            <div className='resp-content'>
                <img src="https://via.placeholder.com/55x55" alt="" />
                <input type="text" id='resp'/>
                <label htmlFor="resp">Répondre à ce topic</label>
            </div>
        </div>
    }
}
export default TopicResponse;