<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

<div class="measurement-page-container">
  <div class="measurement-form-container">
    <table>
      <thead>
        <tr>
          <th>Measurement Type & Description</th>
          <th>Measurement (inch)</th>
          <th>Designs</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <strong>Neck Circumference</strong>
            <p>Around the base of the neck</p>
          </td>
          <td>
            <select class="select">
              <option>6</option>
              <option>7</option>
              <option>8</option>
              <option>9</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
            </select>
          </td>
          <td><a href="<?php echo URLROOT ?>/Designs/collarDesigns"><button class="design-button">Collar Designs</button></a></td>
        </tr>
        <tr>
          <td>
            <strong>Chest</strong>
            <p>Fullest part of the chest</p>
          </td>
          <td>
            <select class="select">
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
            </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <strong>Waist</strong>
            <p>Narrowest part of the waist</p>
          </td>
          <td>
            <select class="select">
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
            </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <strong>Hip</strong>
            <p>Fullest part of the hips</p>
          </td>
          <td>
            <select class="select">
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
            </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <strong>Shoulder Width</strong>
            <p>Distance between shoulder seams</p>
          </td>
          <td>
            <select class="select">
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
            </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <strong>Sleeve Length</strong>
            <p>From shoulder seam to wrist</p>
          </td>
          <td>
            <select class="select">
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
            </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <strong>Armhole</strong>
            <p>Circumference of the armhole</p>
          </td>
          <td>
            <select class="select">
              <option>6</option>
              <option>7</option>
              <option>8</option>
              <option>9</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
            </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <strong>Shirt Length</strong>
            <p>From the base of the neck to the hem</p>
          </td>
          <td>
            <select class="select">
              <option>18</option>
              <option>19</option>
              <option>20</option>
              <option>21</option>
              <option>22</option>
              <option>23</option>
              <option>24</option>
            </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <strong>Cuff Circumference</strong>
            <p>Around the wrist</p>
          </td>
          <td>
            <select class="select">
              <option>6</option>
              <option>7</option>
              <option>8</option>
              <option>9</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
            </select>
          </td>
          <td><a href="<?php echo URLROOT ?>/Designs/cuffDesigns"><button class="design-button">Cuff Designs</button></a></td>
        </tr>
      </tbody>
    </table>

    <div class="buttons">
      <a href="<?php echo URLROOT ?>/Designs/appointment"><button class="submit-button">Submit</button></a>
    </div>
  </div>
  <div class="design-image-container">
    <img src="<?php echo URLROOT; ?>/public/img/designs/still-life-with-classic-shirts-hanger.jpg" alt="Design">
    <div class="design-details">
      <div class="design-name">
        <span>Design Name</span>
      </div>
      <div class="design-description">
        <span>Design Description</span>
      </div>
    </div>
  </div>
  </body>

  </html>