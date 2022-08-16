import React from "react";
import { useParams } from "react-router-dom";
import { getMessage, useFetchApi } from "../../../class/Api";
import {DateFormater} from '../../../class/DateFormater'
import { UrlBuilder } from "../../../class/UrlBuilder";
import {TopicResponse} from './TopicResponse'

export function TopicMessage({limit}){
    const params = useParams()
    const url = new UrlBuilder('http://localhost:8000', 'message').id(params.id).order("created_at", "asc").limit(limit).toUrl()
    const {items, error, IsLoaded} = useFetchApi(url)





        return <> {items.map(item => (
            <div className="messages-content">
            <h2>{item.created_by}</h2>
            <div className="user-info">
                <img src="https://via.placeholder.com/55x55" alt="" />
                <p>Admin</p>
            </div>
            <div className="msg-head"><p>Posté le {new DateFormater(item.created_at).getDate()}</p>{item.author ? <div className="author"><p>Auteur</p></div>: ''}</div>
            <div className="content">{item.content}</div>
        </div>

        ))}
        <TopicResponse/>
        </>
            
}