import React from 'react';
import PropTypes from 'prop-types';
import cn from 'classnames';

import styles from './index.module.scss';

function UntitledPage(props) {
  return (
    <section
      className={cn(styles.mainContentSection, props.className, 'untitled-page')}
      style={{ '--src': `url(${'/assets/a86c5dc48334cdbd123c44b062dd9874.png'})` }}>
      {/* Main content section containing search and summary elements. */}

      <div className={styles.flexColumnContainer}>
        <div className={styles.flexRowSearchResults}>
          <button className={styles.searchButton}>
            {/* TODO */}
            <p className={styles.searchButtonText}>
              {/* Text label for the search button. */}
              Type to sreach
            </p>
            <img
              className={styles.searchButtonIcon}
              src={'/assets/2c4818e11df803407d823720de398910.svg'}
              alt="alt text"
            />
          </button>

          <img className={styles.galleryImage1} src={'/assets/e381809811cb6e36ec112b1a2335b732.png'} alt="alt text" />
          <img className={styles.galleryImage2} src={'/assets/75e818eb32a8bf7ab9cfd80d7badf611.png'} alt="alt text" />

          <div className={styles.infoColumn}>
            <p className={styles.titleText}>Title</p>
            <p className={styles.descriptionText}>Description</p>
          </div>

          <img className={styles.galleryImage3} src={'/assets/fa38fde91b7a63ce6d590b003c4ce597.svg'} alt="alt text" />
        </div>

        <div className={styles.flexRowContent}>
          <div className={styles.contentBox}>
            <div className={styles.flexRowItems}>
              <div className={styles.flexColumnDashboard}>
                <figure className={styles.dashboardImage}>
                  <img className={styles.image3} src={'/assets/cf3615ba69683346e7534a38d4cd93cb.svg'} alt="alt text" />
                  <h3 className={styles.dashboardSubtitle}>Dashboard</h3>
                </figure>

                <div className={styles.flexColumnProfile}>
                  <img
                    className={styles.profileImage}
                    src={'/assets/21e715d6994dc7615791ec9cd91019ca.png'}
                    alt="alt text"
                  />
                  <h3 className={styles.profileSubtitle}>Profile</h3>
                </div>

                <div className={styles.flexColumnOrders}>
                  <img
                    className={styles.ordersImage}
                    src={'/assets/da87db1f41b7db354337621c5c8a720e.png'}
                    alt="alt text"
                  />
                  <h3 className={styles.ordersSubtitle}>Orders</h3>
                </div>

                <div className={styles.flexColumnAppointments}>
                  <img
                    className={styles.appointmentsImage}
                    src={'/assets/e2ef4cccb417950f4da63938172288f9.png'}
                    alt="alt text"
                  />
                  <h3 className={styles.appointmentsSubtitle}>Appointments</h3>
                </div>

                <div className={styles.flexColumnCustomizationHub}>
                  <img
                    className={styles.customizationHubImage}
                    src={'/assets/9ccc73da56fffe081d1ed824fcb6bcf3.png'}
                    alt="alt text"
                  />
                  <h3 className={styles.customizationHubSubtitle}>Custermization Hub</h3>
                </div>

                <div className={styles.flexColumnFabricStock}>
                  <img
                    className={styles.fabricStockImage}
                    src={'/assets/8897f6c0185ed84c49d727122d515310.svg'}
                    alt="alt text"
                  />
                  <h3 className={styles.fabricStockSubtitle}>Fabric Stock</h3>
                </div>
              </div>
            </div>

            <img className={styles.galleryImage5} src={'/assets/415d739b825e259e55df69d356c84ef3.png'} alt="alt text" />
          </div>

          <div className={styles.flexRowSummary}>
            <div className={styles.summaryContentBox}>
              <div className={styles.flexColumnCurrentOrders}>
                <h1 className={styles.currentOrdersHeroTitle}>1,247</h1>
                <h3 className={styles.currentOrdersSubtitle}>Current Orders</h3>
              </div>
            </div>

            <div className={styles.upcomingAppointmentsContentBox}>
              <div className={styles.flexColumnUpcomingAppointments}>
                <img
                  className={styles.upcomingAppointmentsImage}
                  src={'/assets/b2ce940e69f644cdbb89574ddd163a12.png'}
                  alt="alt text"
                />
                <h1 className={styles.upcomingAppointmentsHeroTitle}>247</h1>
                <h3 className={styles.upcomingAppointmentsSubtitle}>Upcoming Appointments</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

UntitledPage.propTypes = {
  className: PropTypes.string
};

export default UntitledPage;
