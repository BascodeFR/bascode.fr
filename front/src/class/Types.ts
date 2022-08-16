export interface Article {
    id: Number,
    slug: String,
    author: boolean,
    name: String,
    created_by: String,
    created_at: Date,
    totalMessage: Number
}

export interface Message {
    id: number,
    name: string,
    content: string,
    created_by: String,
    created_at: Date
}