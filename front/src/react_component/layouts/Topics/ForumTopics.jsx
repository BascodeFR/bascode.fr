import React from 'react'


export function ForumTopics({lastInfo}){
        if (lastInfo == 'true') {
            return <div className="topics">
                <div className="topics-create-info">
                    <a href="forum/base-de-donnee-1" className="topics-name active">Problème de Base de donnée</a>
                    <p>Crée par Cavernos</p>
                    <p>Commencé le 23 Février</p>
                </div>
                <div className="topics-last-info">
                    <div className="total-posts">3 <br />Posts</div>
                    <div className="last-post">
                        <div className="last-post-text">
                            Dernier Post :
                        </div>

                        <img src="https://via.placeholder.com/55x55" alt="" />
                        <p>Cavernos</p>
                    </div>
                </div>
            </div>
        } else {
            return <div className="topics">
                <div className="topics-create-info">
                    <a href="forum/base-de-donnee-1" className="topics-name active">Problème de Base de donnée</a>
                    <p>Crée par Cavernos</p>
                    <p>Commencé le 23 Février</p>
                </div>
            </div>
        }
    }