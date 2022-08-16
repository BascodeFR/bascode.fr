
import { Dispatch, SetStateAction, useEffect, useState } from "react";
import { Article } from "./Article";
Array
export function useFetchApi (url: RequestInfo, limit = 0){
    const [error, setError]: [null, Dispatch<SetStateAction<null>>] = useState(null);
    const [IsLoaded, setIsLoaded]: [boolean, Dispatch<SetStateAction<boolean>>] = useState(false);
    const [items, setItems]: [Article[], Dispatch<SetStateAction<never[]>>] = useState([]);
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

export function getName(id: number){
    const {items} = useFetchApi('http://localhost:8000/post?id='+ id);
    return items.name
}