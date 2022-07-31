import React from 'react'
import {Layout} from './Layout'
import {CardContainer} from '../layouts/Bases/CardContainer'
import {Container} from '../layouts/Bases/Container'
import {TopicMessage} from '../layouts/Topics/TopicMessage'
import {TopicResponse} from '../layouts/Topics/TopicResponse'



export function TopicView(){
        return <Layout>
                    <Container view={['Accueil ', '> Forum ', ' > Problème de Base de données']}>
                        <CardContainer CssClass="topic-message" name='Problème de Base de données'>
                            <TopicMessage/>
                            <TopicMessage/>
                            <TopicMessage/>
                            <TopicMessage/>
                            <TopicResponse/>
                        </CardContainer>
                    </Container>
            </Layout>          
}