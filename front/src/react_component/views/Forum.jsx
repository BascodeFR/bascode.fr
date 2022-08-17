import React, { useMemo, useState }  from 'react'
import{Layout} from './Layout'
import {Container} from '../layouts/Bases/Container'
import {CardContainer} from '../layouts/Bases/CardContainer'
import {ForumTopics} from '../layouts/Topics/ForumTopics'
import { Paginations } from '../layouts/Topics/Pagination'
import { getItemsForPages } from '../../class/Api'
import { UrlBuilder } from '../../class/UrlBuilder'

export function Forum(){
    const PageSize = 10;
    const [currentPage, setCurrentPage] = useState(1);
    const items = getItemsForPages()
    const currentTableData = useMemo(() => {
        const firstPageIndex = (currentPage - 1) * PageSize;
        const lastPageIndex = firstPageIndex + PageSize;
        return items.slice(firstPageIndex, lastPageIndex);
      }, [currentPage]);
    
    return <Layout>
                <Container view={['Accueil ', '> Forum']}>
                    <CardContainer CssClass="forum" name='Forum'>
                        <ForumTopics currentTable={currentTableData}/>
                        <Paginations currentPage={currentPage} totalCount={items.length} pageSize={PageSize} onPageChange={page => setCurrentPage(page)}/>
                    </CardContainer>
                </Container>
            </Layout>
} 