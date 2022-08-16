import React from 'react'
import {Layout} from './Layout'
import {CardContainer} from '../layouts/Bases/CardContainer'
import {Container} from '../layouts/Bases/Container'
import {TopicMessage} from '../layouts/Topics/TopicMessage'
import {TopicResponse} from '../layouts/Topics/TopicResponse'
import { getName } from '../../class/Api'
import { useParams } from 'react-router-dom'



export function TopicView(){
    const params = useParams()
    const name = getName(params.id)   
        return <Layout>
                    <Container view={['Accueil ', '> Forum ', ' > ' + name]}>
                        <CardContainer CssClass="topic-message" name={name}>
                            <TopicMessage/>
                            <TopicMessage/>
                            <TopicMessage/>
                            <TopicMessage/>
                            <TopicResponse/>
                        </CardContainer>
                    </Container>
            </Layout>          
}