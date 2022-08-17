import React from 'react'



export function TopicResponse(){
        return  <div className="resp">
                    <h2>Rejoindre la conversation</h2>
                    <form className='resp-content'>
                        <img src="https://via.placeholder.com/55x55" alt="" />
                            <textarea type="text" id='resp'></textarea>
                            <label htmlFor="resp">Répondre à ce topic</label>
                            <button type='submit' className='btn'>Répondre</button>
                        
                    </form>
                </div>
}
export default TopicResponse;