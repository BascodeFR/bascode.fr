import ReactDOM from 'react-dom/client'
import CardContainer from '../layouts/card_container'
import ForumTopics from '../layouts/topics/forum'

import Container from '../layouts/container'
import Layout from './layout'


ReactDOM.createRoot(document.getElementById('root')).render(<>
<Layout>
    <Container view='Accueil > Forum'>
        <CardContainer className="forum" name='Forum'>
        <ForumTopics lastInfo='true'/>
            <ForumTopics lastInfo='true'/>
            <ForumTopics lastInfo='true'/>
            <ForumTopics lastInfo='true'/>
            <ForumTopics lastInfo='true'/>
            <ForumTopics lastInfo='true'/>
            <ForumTopics lastInfo='true'/>
            <ForumTopics lastInfo='true'/>
            <ForumTopics lastInfo='true'/>
            <ForumTopics lastInfo='true'/>
        </CardContainer>
    </Container>
</Layout>

</>)