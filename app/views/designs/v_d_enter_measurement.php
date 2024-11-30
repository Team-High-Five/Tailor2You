<?php require_once APPROOT . '/views/designs/inc/header.php'; ?>
<?php require_once APPROOT . '/views/pages/inc/components/topnav.php'; ?>

  <div class="measurement-form-container">
    <table>
      <thead>
        <tr>
          <th>Measurement Type</th>
          <th>Description</th>
          <th>Measurement (inch)</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Neck Circumference</td>
          <td>Around the base of the neck</td>
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
          <td><a href="<?php echo URLROOT ?>/Designs/collarDesigns"><button style="background-color: #d9b99b;">Collar Designs</button></a></td>
        </tr>
        <tr>
          <td>Chest</td>
          <td>Fullest part of the chest</td>
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
          <td>Waist</td>
          <td>Narrowest part of the waist</td>
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
          <td>Hip</td>
          <td>Fullest part of the hips</td>
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
          <td>Shoulder Width</td>
          <td>Distance between shoulder seams</td>
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
          <td>Sleeve Length</td>
          <td>From shoulder seam to wrist</td>
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
          <td>Armhole</td>
          <td>Circumference of the armhole</td>
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
          <td>Shirt Length</td>
          <td>From the base of the neck to the hem</td>
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
          <td>Cuff Circumference</td>
          <td>Around the wrist</td>
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
          <td><a href="<?php echo URLROOT ?>/Designs/cuffDesigns"><button style="background-color: #d9b99b;">Cuff Designs</button></a></td>
        </tr>
      </tbody>
    </table>

    <div class="buttons">
    <a href="<?php echo URLROOT ?>/Designs/appointment"><button>Submit</button></a>
    </div>
  </div>
</body>
</html>
