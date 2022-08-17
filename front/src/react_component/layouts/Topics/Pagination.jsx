import { usePagination, DOTS } from '../../../class/usePagination'
//import classnames from 'classNames'

export function Paginations(props){

    const {
        onPageChange,
        totalCount,
        siblingCount = 1,
        currentPage,
        pageSize,
        className
      } = props;

      const paginationRange = usePagination({
        currentPage,
        totalCount,
        siblingCount,
        pageSize
      });
      if (currentPage === 0 || paginationRange.length < 2) {
        return null;
      }

      const onNext = () => {
        onPageChange(currentPage + 1);
      };
    
      const onPrevious = () => {
        onPageChange(currentPage - 1);
      };

      let lastPage = paginationRange[paginationRange.length - 1];
    return <div className="pagination">
        <button onClick={onPrevious} key="prev" className={currentPage === 1 ? "pages prev disabled" : "pages prev"}></button>
        {
        paginationRange.map(pageNumber =>{
            if (pageNumber === DOTS) {
                return <button key={DOTS} className="pages">{DOTS}</button>;
              }

            return <button key={pageNumber} className="pages" onClick={() => onPageChange(pageNumber)}>{pageNumber}</button>
         })}
        <button onClick={onNext} key="next" className={currentPage === lastPage ? "pages next disabled" : "pages next"} ></button>
    </div>
}