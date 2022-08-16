import React from "react";
import { useParams } from "react-router-dom";
import { getMessage, useFetchApi } from "../../../class/Api";
import {DateFormater} from '../../../class/DateFormater'
import {TopicResponse} from './TopicResponse'

export function TopicMessage({limit}){
    const params = useParams()
    const {items, error, IsLoaded} = useFetchApi('http://localhost:8000/message?id=' + params.id + '&order=asc&field=created_at&limit=' + limit)





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