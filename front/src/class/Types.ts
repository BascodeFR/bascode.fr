export interface Article {
    id: Number,
    slug: String,
    author: boolean,
    name: String,
    created_by: String,
    created_at: Date,
    totalMessage: Number,
    [key: string]: any
}

export interface Message {
    id: number,
    name: string,
    content: string,
    created_by: String,
    created_at: Date
}

export interface User {
    id: number,
    name: string,
    username: string,
    email: string,
    password: string
}