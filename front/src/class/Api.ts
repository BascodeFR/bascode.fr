
import { Dispatch, SetStateAction, useEffect, useState } from "react";
import { Article, Message } from "./Types";
import {UrlBuilder} from './UrlBuilder';


/**
 * @param  {RequestInfo} url
 * @param  {} limit=0
 * @returns Object
 */
export function useFetchApi (url: RequestInfo, limit = 0){
    const [error, setError]: [null, Dispatch<SetStateAction<null>>] = useState(null);
    const [IsLoaded, setIsLoaded]: [boolean, Dispatch<SetStateAction<boolean>>] = useState(false);
    const [items, setItems]: [never[], Dispatch<SetStateAction<never[]>>] = useState([]);
    url = limit > 0 ? url.toString() + limit.toString() : url
    useEffect(() => {
        fetch(url)
            .then(res => res.json())
            .then((items: SetStateAction<never[]>) => {
                setIsLoaded(true)
                setItems(items)
            }, (error: SetStateAction<null>) => {
                setIsLoaded(true);
                setError(error);
            })    

    }, [url])
    const resp = {items, error ,IsLoaded}
    return resp
    
}
/**
 * @param  {number} id
 * @returns Article
 */
export function getName(id: number): Article[]{
    const url = new UrlBuilder('http://localhost:8000', 'post').id(id).toUrl()
    const {items}= useFetchApi(url);
    return items['name']
}
/**
 * @param  {number} id
 * @returns Message
 */
export function getMessage(id: number): Message[] {
    const url = new UrlBuilder('http://localhost:8000', 'message').id(id).toUrl()
    const {items} = useFetchApi(url)
    return items
}