// @ts-nocheck
import { useEffect, useState } from "react";

export function useFetchApi (url, limit = 0){
    const [error, setError] = useState(null);
    const [IsLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState([]);
    url = limit > 0 ? url + Object.values({limit}): url
    useEffect(() => {
        ( async function(){
            fetch(url)
            .then(res => res.json() )
            .then((items) =>{
                setIsLoaded(true);
                setItems(items);
            }, (error) => {
                setIsLoaded(true);
                setError(error);
            }
        )
    }
)()
        
    }, [url]) 
    const resp = {items, error ,IsLoaded}
    return resp
}

export function getName(id){
    const {items} = useFetchApi('http://localhost:8000/post?id='+ id);
    return items.name
}