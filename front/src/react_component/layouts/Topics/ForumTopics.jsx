import React, { useMemo, useState } from 'react'
import { useParams } from 'react-router-dom';
import { useFetchApi } from '../../../class/api';
import {DateFormater} from '../../../class/DateFormater'
import { UrlBuilder } from '../../../class/UrlBuilder';



export function ForumTopics({limit,currentTable}){
    let url = ""
    if(limit != undefined){
        url = new UrlBuilder('http://localhost:8000', 'post').order("created_at", "desc").limit(limit).toUrl()
    } else {
        url = new UrlBuilder('http://localhost:8000', 'post').order("created_at", "desc").toUrl()
    }
    
    const {items, error ,IsLoaded} = useFetchApi(url)
    const params = useParams();
    function getSlug(){
        for(let i = 0; i < limit; i++){
            return items.map(item => {
                return [item.slug][i] + '-' + [item.id][i] 
            })
        }
    }



    if (error) {
        return <div className="errors">Erreur : {error.message}</div>; 
      } else if (!IsLoaded) {
        return <div className='loading'><img src="/Maquette/logo/bascode.png" alt="" /></div>;
      } else {
            return <>{currentTable !== undefined ? currentTable.map(item => (
                <div className="topics" key={item.id}>
                    <div className="topics-create-info">
                        <a href={"forum/" + item.slug + '-' + item.id } className="topics-name active">{item.name}</a>
                        <p>Crée par {item.created_by}</p>
                        <p>Commencé le {new DateFormater(item.created_at).getDate()}</p>
                    </div>
                    <div className="topics-last-info">
                        <div className="total-posts">{item.total_messages} <br />Posts</div>
                        <div className="last-post">
                            <div className="last-post-text">
                                Dernier Post :
                            </div>

                            <img src="https://via.placeholder.com/55x55" alt="" />
                            <p>Cavernos</p>
                        </div>
                    </div>
                </div>
            )): items.map(item => (
                <div className="topics" key={item.id}>
                    <div className="topics-create-info">
                        <a href={"forum/" + item.slug + '-' + item.id } className="topics-name active">{item.name}</a>
                        <p>Crée par {item.created_by}</p>
                        <p>Commencé le {new DateFormater(item.created_at).getDate()}</p>
                    </div>
                    <div className="topics-last-info">
                        <div className="total-posts">{item.total_messages} <br />Posts</div>
                        <div className="last-post">
                            <div className="last-post-text">
                                Dernier Post :
                            </div>

                            <img src="https://via.placeholder.com/55x55" alt="" />
                            <p>Cavernos</p>
                        </div>
                    </div>
                </div>))}
            </>
            
        } 
    }