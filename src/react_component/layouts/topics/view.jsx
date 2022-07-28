import React from 'react'
import Layout from '../../views/layout';
import CardContainer from '../card_container';
import Container from '../container';
import TopicMessage from './message';
import TopicResponse from './response';


class TopicView extends React.Component{
    render(){
        return <Layout>
        <Container view='Accueil > Forum > Problème de Base de données'>
            <CardContainer className="topic-message" name='Problème de Base de données'>
                <TopicMessage/>
                <TopicMessage/>
                <TopicMessage/>
                <TopicMessage/>
                <TopicResponse/>
            </CardContainer>
        </Container>
    </Layout>          
    }
}
export default TopicView;